<?php

class Jelo extends Db {
    public $jid;
    public $sort;
    public $broj;
    public $naziv;
    public $naziv_en;
    public $cijena;
    public $mid;

    public function __construct() {
        parent::__construct();
    }

    public function getJela($value) {
        //var_dump($this->pdo);
        $sql = 'SELECT * FROM jela WHERE mid = :mid ORDER BY sort';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':mid' => $value,
        ]);
        $result = $stmt->fetchAll();

        return $result;
    }

    public function chooseJelo($value) {
        $sql = 'SELECT * FROM jela WHERE jid=:jid';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':jid' => $value,
        ]);

        $result = $stmt->fetchAll();

        return $result;
    }

    public function insertJelo($sort, $broj, $naziv, $naziv_en, $cijena, $mid) {
        $sql =
            'INSERT into jela (sort, broj, naziv, naziv_en, cijena, mid) VALUES (:sort, :broj, :naziv, :naziv_en, :cijena,:mid)';
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':sort' => $sort,
            ':broj' => $broj,
            ':naziv' => $naziv,
            ':naziv_en' => $naziv_en,
            ':cijena' => $cijena,
            ':mid' => $mid,
        ]);
    }

    public function deleteJelo($jid) {
        $sql = 'DELETE  FROM jela WHERE jid = :jid';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':jid' => $jid,
        ]);
    }

    public function editJelo($jid, $broj, $sort, $naziv, $naziv_en, $cijena) {
        $sql =
            'UPDATE jela SET broj= :broj, sort= :sort, naziv= :naziv, naziv_en= :naziv_en, cijena= :cijena WHERE jid = :jid';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':jid' => $jid,
            ':sort' => $sort,
            ':broj' => $broj,
            ':naziv' => $naziv,
            ':naziv_en' => $naziv_en,
            ':cijena' => $cijena,
        ]);
    }
}
