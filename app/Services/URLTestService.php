<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class URLTestService
{
    protected $googleApiKey;
    protected $virusTotalApiKey;
    protected $abuseIPDBApiKey;

    public function __construct()
    {
        $this->googleApiKey = config('services.google.safe_browsing_key');
        $this->virusTotalApiKey = config('services.virustotal.api_key');
        $this->abuseIPDBApiKey = config('services.abuseipdb.api_key');
    }

    public function checkURLSafety(string $url): array
    {
        $results = [
            'is_safe' => true,
            'details' => [],
        ];

        $googleResult = $this->checkGoogleSafeBrowsing($url);
        $results['details']['google_safe_browsing'] = $googleResult;
        if (!$googleResult['safe']) {
            $results['is_safe'] = false;
        }

        $virusTotalResult = $this->checkVirusTotal($url);
        $results['details']['virus_total'] = $virusTotalResult;
        if ($virusTotalResult['malicious'] > 0) {
            $results['is_safe'] = false;
        }

        $abuseIPDBResult = $this->checkAbuseIPDB($url);
        $results['details']['abuse_ipdb'] = $abuseIPDBResult;
        if ($abuseIPDBResult['is_abused']) {
            $results['is_safe'] = false;
        }

        return $results;
    }

    protected function checkGoogleSafeBrowsing(string $url): array
    {
        $cacheKey = 'google_sb_' . md5($url);

        return Cache::remember($cacheKey, now()->addHours(6), function () use ($url) {
            try {
                $response = Http::post(
                    'https://safebrowsing.googleapis.com/v4/threatMatches:find?key=' . $this->googleApiKey,
                    [
                        'client' => [
                            'clientId' => 'ResiliShare',
                            'clientVersion' => '1.0.0',
                        ],
                        'threatInfo' => [
                            'threatTypes' => ['MALWARE', 'SOCIAL_ENGINEERING', 'UNWANTED_SOFTWARE', 'POTENTIALLY_HARMFUL_APPLICATION'],
                            'platformTypes' => ['ANY_PLATFORM'],
                            'threatEntryTypes' => ['URL'],
                            'threatEntries' => [['url' => $url]]
                        ]
                    ]
                );

                $data = $response->json();

                if (isset($data['matches'])) {
                    $threats = array_unique(array_column($data['matches'], 'threatType'));
                    return [
                        'safe' => false,
                        'threats' => $threats,
                        'response' => $data
                    ];
                }

                return [
                    'safe' => true,
                    'threats' => [],
                    'response' => $data
                ];
            } catch (\Exception $e) {
                return $this->handleApiError('Google Safe Browsing', $e, [
                    'safe' => true,
                    'threats' => []
                ]);
            }
        });
    }

    protected function checkVirusTotal(string $url): array
    {
        $cacheKey = 'virustotal_' . md5($url);

        return Cache::remember($cacheKey, now()->addHours(6), function () use ($url) {
            try {
                $scanResponse = Http::withHeaders([
                    'x-apikey' => $this->virusTotalApiKey
                ])->post('https://www.virustotal.com/api/v3/urls', [
                    'url' => $url
                ]);

                $scanData = $scanResponse->json();
                $analysisId = $scanData['data']['id'] ?? null;

                if (!$analysisId) {
                    throw new \Exception('Failed to submit URL to VirusTotal');
                }

                sleep(5); 

                $analysisResponse = Http::withHeaders([
                    'x-apikey' => $this->virusTotalApiKey
                ])->get("https://www.virustotal.com/api/v3/analyses/{$analysisId}");

                $analysisData = $analysisResponse->json();
                $stats = $analysisData['data']['attributes']['stats'] ?? [];
                $engines = $analysisData['data']['attributes']['results'] ?? [];

                $engineResults = [];
                foreach ($engines as $engine => $result) {
                    if ($result['category'] === 'malicious') {
                        $engineResults[$engine] = 'malicious';
                    }
                }

                return [
                    'malicious' => $stats['malicious'] ?? 0,
                    'suspicious' => $stats['suspicious'] ?? 0,
                    'harmless' => $stats['harmless'] ?? 0,
                    'undetected' => $stats['undetected'] ?? 0,
                    'engines' => $engineResults,
                    'response' => $analysisData
                ];
            } catch (\Exception $e) {
                return $this->handleApiError('VirusTotal', $e, [
                    'malicious' => 0,
                    'suspicious' => 0,
                    'harmless' => 0,
                    'undetected' => 0,
                    'engines' => []
                ]);
            }
        });
    }

    protected function checkAbuseIPDB(string $url): array
    {
        $domain = parse_url($url, PHP_URL_HOST);
        $ip = gethostbyname($domain);
        $cacheKey = 'abuseipdb_' . md5($ip);

        return Cache::remember($cacheKey, now()->addHours(6), function () use ($ip) {
            try {
                $response = Http::withHeaders([
                    'Key' => $this->abuseIPDBApiKey,
                    'Accept' => 'application/json'
                ])->get('https://api.abuseipdb.com/api/v2/check', [
                    'ipAddress' => $ip,
                    'maxAgeInDays' => 90
                ]);

                $data = $response->json();

                return [
                    'is_abused' => $data['data']['abuseConfidenceScore'] > 0,
                    'abuse_confidence_score' => $data['data']['abuseConfidenceScore'],
                    'total_reports' => $data['data']['totalReports'],
                    'isp' => $data['data']['isp'],
                    'domain' => $data['data']['domain'],
                    'response' => $data
                ];
            } catch (\Exception $e) {
                return $this->handleApiError('AbuseIPDB', $e, [
                    'is_abused' => false,
                    'abuse_confidence_score' => 0,
                    'total_reports' => 0,
                    'isp' => null,
                    'domain' => null
                ]);
            }
        });
    }

    protected function handleApiError(string $service, \Exception $e, array $defaultResponse): array
    {
        Log::error("{$service} API error: " . $e->getMessage());

        return array_merge($defaultResponse, [
            'error' => true,
            'error_message' => "{$service} API unavailable. Results may not be complete.",
            'exception' => $e->getMessage()
        ]);
    }
}
