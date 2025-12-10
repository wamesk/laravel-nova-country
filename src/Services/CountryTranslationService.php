<?php

declare(strict_types = 1);

namespace Wame\LaravelNovaCountry\Services;

use Illuminate\Support\Str;

class CountryTranslationService
{
    /**
     * ISO 639-1 (2-letter) to ISO 639-3 (3-letter) language code mapping
     */
    protected static array $localeMap = [
        'sk' => 'slk',
        'cs' => 'ces',
        'en' => 'eng',
        'de' => 'deu',
        'fr' => 'fra',
        'es' => 'spa',
        'it' => 'ita',
        'pl' => 'pol',
        'hu' => 'hun',
        'ru' => 'rus',
        'uk' => 'ukr',
        'pt' => 'por',
        'nl' => 'nld',
        'ro' => 'ron',
        'bg' => 'bul',
        'hr' => 'hrv',
        'sl' => 'slv',
        'sr' => 'srp',
        'tr' => 'tur',
        'el' => 'ell',
        'zh' => 'zho',
        'ja' => 'jpn',
        'ko' => 'kor',
        'ar' => 'ara',
        'he' => 'heb',
        'vi' => 'vie',
        'th' => 'tha',
        'sv' => 'swe',
        'da' => 'dan',
        'fi' => 'fin',
        'no' => 'nor',
        'et' => 'est',
        'lv' => 'lav',
        'lt' => 'lit',
    ];

    /**
     * Get translated country name
     */
    public static function getTranslatedName(string $countryCode, ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $country = country($countryCode);

        if (!$country) {
            return $countryCode;
        }

        $iso3Locale = self::getIso3Locale($locale);
        $translations = $country->getTranslations();

        if (isset($translations[$iso3Locale]['common'])) {
            return $translations[$iso3Locale]['common'];
        }

        // Fallback to English
        if (isset($translations['eng']['common'])) {
            return $translations['eng']['common'];
        }

        // Final fallback to default name
        return $country->getName();
    }

    /**
     * Search countries by name in specified locale
     * Returns array of country codes that match the search term
     */
    public static function searchByName(string $search, ?string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();
        $search = Str::lower($search);
        $matchingCodes = [];

        $countries = countries();

        foreach ($countries as $countryCode => $country) {
            $translatedName = self::getTranslatedName($countryCode, $locale);

            if (Str::contains(Str::lower($translatedName), $search)) {
                $matchingCodes[] = $countryCode;
            }

            // Also search by country code
            if (Str::contains(Str::lower($countryCode), $search)) {
                $matchingCodes[] = $countryCode;
            }
        }

        return array_unique($matchingCodes);
    }

    /**
     * Get all countries with translated names for current locale
     * Returns array of [code => translated_name]
     */
    public static function getAllTranslated(?string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();
        $result = [];

        $countries = countries();

        foreach ($countries as $countryCode => $country) {
            $result[$countryCode] = self::getTranslatedName($countryCode, $locale);
        }

        return $result;
    }

    /**
     * Convert ISO 639-1 (2-letter) to ISO 639-3 (3-letter) locale code
     */
    protected static function getIso3Locale(string $locale): string
    {
        // Handle locales with region (e.g., 'en_US' -> 'en')
        $locale = Str::before($locale, '_');
        $locale = Str::before($locale, '-');

        return self::$localeMap[$locale] ?? 'eng';
    }
}
