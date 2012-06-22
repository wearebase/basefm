<?php

namespace Basefm;

class NowPlayingRepository {

    private $dbh;

    public function __construct($dbh)
    {
        $this->dbh = $dbh;

    }

    public function add($track)
    {
        error_log(implode(", ", $track));
        
        return 1;

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


    public function getNowPlaying()
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

