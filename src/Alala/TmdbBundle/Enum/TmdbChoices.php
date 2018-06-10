<?php
namespace Alala\TmdbBundle\Enum;

abstract class TmdbChoices
{
    public const SORT_BY_MOVIE = [
        'popularity.asc',
        'popularity.desc',
        'release_date.asc',
        'release_date.desc',
        'revenue.asc',
        'revenue.desc',
        'primary_release_date.asc',
        'primary_release_date.desc',
        'original_title.asc',
        'original_title.desc',
        'vote_average.asc',
        'vote_average.desc',
        'vote_count.asc',
        'vote_count.desc'
    ];
    
    public const QUERY_MOVIES = [
        'discover' => [
            'desc' => 'Discover movies by different types of data',
            'link' => 'discover/movie',
            'parameters' => [
                'language' => [
                    'title' => 'Chose your language',
                    'type' => 'string',
                    'required' => false,
                    'default' => ['language']
                ],
                'region' => [
                    'title' => 'Chose region',
                    'type' => 'string',
                    'required' => false,
                    'default' => null
                ],
                'sort_by' => [
                    'title' => 'Chose the sort by result',
                    'type' => 'array',
                    'list' => self::SORT_BY_MOVIE,
                    'required' => false,
                    'default' => ['discover','sortby']
                ],
                'certification_country' => [
                    'title' => 'Certification country ?',
                    'type' => 'boolean',
                    'required' => false,
                    'default' => false
                ],
                'certification' => [
                    'title' => 'Certification ?',
                    'type' => 'string',
                    'required' => false,
                    'default' => null
                ],
                'certification.lte' => [
                    'title' => 'Chose the certification less than',
                    'type' => 'string',
                    'required' => false,
                    'default' => null
                ],
                'include_adult' => [
                    'title' => 'Include adult movie?',
                    'type' => 'string',
                    'required' => false,
                    'default' => null
                ],
                'primary_release_date.gte' => [
                    'title' => 'Primary release year greater than',
                    'type' => 'string',
                    'required' => false,
                    'default' => null
                ],
                'primary_release_year.lte' => [
                    'title' => 'Primary release year less than',
                    'type' => 'string',
                    'required' => false,
                    'default' => null
                ],
                'release_date.gte' => [
                    'title' => 'Release year greater than',
                    'type' => 'string',
                    'required' => false,
                    'default' => null
                ],
                'release_date.lte' => [
                    'title' => 'Release year less than',
                    'type' => 'string',
                    'required' => false,
                    'default' => null
                ],
                'vote_count.gte' => [
                    'title' => 'Vote count greater than',
                    'type' => 'integer',
                    'required' => false,
                    'default' => null
                ],
                'vote_count.lte' => [
                    'title' => 'Vote count less than',
                    'type' => 'integer',
                    'required' => false,
                    'default' => null
                ],
                'vote_average.gte' => [
                    'title' => 'Vote average greater than',
                    'type' => 'integer',
                    'required' => false,
                    'default' => null
                ],
                'vote_average.lte' => [
                    'title' => 'Vote average less than',
                    'type' => 'integer',
                    'required' => false,
                    'default' => null
                ],
                'with_cast' => [
                    'title' => 'With cast',
                    'type' => 'string',
                    'required' => false,
                    'default' => null
                ],
                'with_crew' => [
                    'title' => 'With crew',
                    'type' => 'string',
                    'required' => false,
                    'default' => null
                ],
                'with_companies' => [
                    'title' => 'With compagnies',
                    'type' => 'string',
                    'required' => false,
                    'default' => null
                ],
                'with_genres' => [
                    'title' => 'With genres',
                    'type' => 'string',
                    'required' => false,
                    'default' => null
                ],
                'without_genres' => [
                    'title' => 'Without genres',
                    'type' => 'string',
                    'required' => false,
                    'default' => null
                ],
                'with_keywords' => [
                    'title' => 'With keywords',
                    'type' => 'string',
                    'required' => false,
                    'default' => null
                ],
                'without_keywords' => [
                    'title' => 'Without keyword',
                    'type' => 'string',
                    'required' => false,
                    'default' => null
                ],
                'with_people' => [
                    'title' => 'With people',
                    'type' => 'string',
                    'required' => false,
                    'default' => null
                ],
                'year' => [
                    'title' => 'Year',
                    'type' => 'integer',
                    'required' => false,
                    'default' => null
                ],
                'with_runtime.gte' => [
                    'title' => 'With runtime greater than',
                    'type' => 'integer',
                    'required' => false,
                    'default' => null
                ],
                'with_runtime.lte' => [
                    'title' => 'With runtime less than',
                    'type' => 'integer',
                    'required' => false,
                    'default' => null
                ],
                'with_release_type' => [
                    'title' => 'With release type',
                    'type' => 'string',
                    'required' => false,
                    'default' => null
                ],
                'with_original_language' => [
                    'title' => 'With original language',
                    'type' => 'string',
                    'required' => false,
                    'default' => null
                ],
                'page' => [
                    'title' => 'page number',
                    'type' => 'integer',
                    'required' => false,
                    'default' => 1
                ]
            ]
        ],
        'search' => [
            'desc' => 'Search for movies.',
            'link' => 'search/movie',
            'parameters' => [
                'language' => [
                    'title' => 'Chose your language',
                    'type' => 'string',
                    'required' => false,
                    'default' => ['language']
                ],
                'query' => [
                    'title' => 'Search query',
                    'type' => 'string',
                    'required' => false,
                    'default' => null
                ],
                'include_adult' => [
                    'title' => 'Include adult movie?',
                    'type' => 'string',
                    'required' => false,
                    'default' => null
                ],
                'region' => [
                    'title' => 'Chose region',
                    'type' => 'string',
                    'required' => false,
                    'default' => null
                ],
                'year' => [
                    'title' => 'Year',
                    'type' => 'integer',
                    'required' => false,
                    'default' => null
                ],
                'primary_release_year' => [
                    'title' => 'Primary release year',
                    'type' => 'integer',
                    'required' => false,
                    'default' => null
                ],
                'page' => [
                    'title' => 'page number',
                    'type' => 'integer',
                    'required' => false,
                    'default' => 1
                ]
            ]
        ],
        'movie' => [
            'desc' => 'Search for movies.',
            'link' => 'movie',
            'url' => [
                [
                    'title' => 'Movie Id',
                    'type' => 'string',
                    'default' => null,
                    'required' => true
                ]
            ],
            'parameters' => [
                'language' => [
                    'title' => 'Chose your language',
                    'type' => 'string',
                    'required' => false,
                    'default' => ['language']
                ]
            ]
        ]
    ];
}

