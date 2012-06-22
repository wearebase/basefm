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
        if ($this->tweetExists($tweet)) {
            error_log('Tweet ' . $tweet->id_str . ' exists');
            return;
        }

        $sth = $this->dbh->prepare("INSERT INTO `tweets` SET 
             `id_str`   = :id_str,
             `tweet`    = :tweet,
             `username` = :username,
             `created`  = :created
        ");

        $sth->execute(array(
            'id_str'   => $tweet->id_str,
            'tweet'    => $tweet->text,
            'username' => $tweet->from_user,
            'created'  => date('Y-m-d H:i:s'),
        ));

        return true;
    }

    private function tweetExists($tweet)
    {
        $sth = $this->dbh->prepare("SELECT COUNT(`id`)
                                 FROM `tweets`
                                 WHERE `id_str` = :id_str
                                 ");

        $sth->execute(array(
            'id_str' => ''.$tweet->id_str,
        ));

        return (bool) $sth->fetchColumn();


    }

    public function getAllSince($since)
    {
        $sth = $this->dbh->prepare("SELECT *
                                 FROM `tweets`
                                 WHERE `created` >= :since
                                 ");

        $sth->execute(array(
            'since' => date('Y-m-d H:i:s', $since),
        ));

        return $sth->fetchAll(\PDO::FETCH_ASSOC);        
    }

}

