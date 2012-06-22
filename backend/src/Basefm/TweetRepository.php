<?php

namespace Basefm;

class TweetRepository {

    private $dbh;

    public function __construct($dbh)
    {
        $this->dbh = $dbh;

    }

    public function add($tweet)
    {
        $exists = $this->tweetExists($tweet);
    }

    private function tweetExists($tweet) {
        $id = $tweet->id_str;
    

        $sth = $this->dbh->prepare("SELECT COUNT(`id`)
                                 FROM `tweets`
                                 WHERE `id_str` = :id_str
                                 ");

        $sth->execute(array(
            'id_str' => $id,
        ));

        $row = $sth->fetch(PDO::FETCH_NUM);

        var_dump($row);

        $sth->execute(array(
            'date_from' => $app['weeks_ago_3'],
            'date_to'   => $app['weeks_ago_2'],
        ));

        $row = $sth->fetch(PDO::FETCH_NUM);
        $total_last_week = @$row[0];

    }


}

