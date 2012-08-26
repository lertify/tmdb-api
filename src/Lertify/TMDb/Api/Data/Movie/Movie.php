<?php

namespace Lertify\TMDb\Api\Data\Movie;

use Lertify\TMDb\Api\Data\AbstractData;

class Movie extends AbstractData
{

    public $id;
    public $original_title;
    public $title;
    public $overview;
    public $tagline;
    public $release_date;
    public $genres;
    public $adult;
    public $homepage;
    public $runtime;
    public $budget;
    public $revenue;
    public $production_companies;
    public $production_countries;
    public $spoken_languages;
    public $belongs_to_collection;


    public $popularity;
    public $imdb_id;
    public $backdrop_path;
    public $poster_path;

    public $vote_average;
    public $vote_count;

}

/*
+"adult": false,
+"backdrop_path": "/mOTtuakUTb1qY6jG6lzMfjdhLwc.jpg",
+"belongs_to_collection": {
      "backdrop_path": "/mOTtuakUTb1qY6jG6lzMfjdhLwc.jpg",
      "id": 10,
      "name": "Star Wars Collection",
      "poster_path": "/6rddZZpxMQkGlpQYVVxb2LdQRI3.jpg"
    },
+"budget": 11000000,
+"genres": [{
      "id": 28,
      "name": "Action"
    },
    {
      "id": 14,
      "name": "Fantasy"
    },
    {
      "id": 878,
      "name": "Science Fiction"
    }],
+"homepage": "http://www.starwars.com",
+"id": 11,
+"imdb_id": "tt0076759",
+"original_title": "Star Wars: Episode IV: A New Hope",
+"overview": "Princess Leia is captured and held hostage by the evil Imperial forces in their effort to take over the galactic Empire. Venturesome Luke Skywalker and dashing captain Han Solo team together with the loveable robot duo R2-D2 and C-3PO to rescue the beautiful princess and restore peace and justice in the Empire.",
+"popularity": 84.8,
+"poster_path": "/qoETrQ73Jbd2LDN8EUfNgUerhzG.jpg",
+"production_companies": [{
      "id": 1,
      "name": "Lucasfilm"
    },
    {
      "id": 8265,
      "name": "Paramount"
    }],
"production_countries": [{
      "iso_3166_1": "TN",
      "name": "Tunisia"
    },
    {
      "iso_3166_1": "US",
      "name": "United States of America"
    }],
+"release_date": "1977-12-27",
+"revenue": 775398007,
+"runtime": 121,
+"spoken_languages": [{
  "iso_639_1": "en",
  "name": "English"
}],
+"tagline": "A long time ago in a galaxy far, far away...",
+"title": "Star Wars: Episode IV: A New Hope",
+"vote_average": 8.8,
+"vote_count": 75
 */
