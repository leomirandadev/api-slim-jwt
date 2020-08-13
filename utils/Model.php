<?php
namespace Utils;

use Settings\ConnectionDB;

class Model extends ConnectionDB
{

    public $table = "";
    public $camps = [];
    protected $sensiveCamps = [];
    protected $values = [];

    /**
     * setCamps
     *
     * @param  array $values
     * @return void
     */
    public function setCamps(array $values): void
    {
        foreach ($this->camps as $camp) {
            if (isset($values[$camp])) {
                $this->values[$camp] = $values[$camp];
            }
        }
    }

    /**
     * create
     *
     * @return int
     */
    public function create(): int
    {
        $this->connect();
        $result = $this->db->insert($this->table, $this->values)->lastInsertId();

        return $result;
    }

    /**
     * read
     *
     * @param  array $where
     * @param  array $removeTheseCamps
     * @return array
     */
    public function read(array $where = [], array $removeTheseCamps = [], array $groupBy = [], array $extraCamp = []): array
    {
        $this->connect();
        $query = $this->db->newQuery();

        $campsWithoutSensiveCamps = $this->deleteSensiveCamps($removeTheseCamps);
        $camps = $this->addMoreCamps($campsWithoutSensiveCamps, $extraCamp);

        $results = $query->select($camps)
            ->where($where)
            ->from($this->table)
            ->group($groupBy)
            ->execute()
            ->fetchAll('assoc');

        return $results;
    }

    /**
     * addMoreCamps
     *
     * @param  array $camps
     * @param  array $addCamps
     * @return array
     */
    private function addMoreCamps(array $camps, array $addCamps): array
    {
        return array_merge($camps, $addCamps);
    }

    /**
     * readJoin
     *
     * @param  array $where
     * @param  array $removeTheseCamps
     * @param  Model $model2
     * @param  string $typeJoin
     * @param  string $conditionJoin
     * @return array
     */
    public function readJoin(array $where = [], array $removeTheseCamps = [], Model $model2, string $typeJoin, string $conditionJoin): array
    {
        $this->connect();
        $query = $this->db->newQuery();

        $campsWithoutSensiveCamps = $this->deleteSensiveCamps($removeTheseCamps);

        // remover o id da segunda tabela
        array_push($removeTheseCamps, "id");
        $campsWithoutSensiveCampsModel2 = $model2->deleteSensiveCamps($removeTheseCamps);

        $camps = $this->formatInnerCamps($campsWithoutSensiveCamps, $campsWithoutSensiveCampsModel2, $model2->table);

        $results = $query->select($camps)
            ->join([
                'table' => $model2->table,
                'type' => $typeJoin,
                'conditions' => "$this->table.$conditionJoin = $model2->table.id",
            ])
            ->where($where)
            ->from($this->table)
            ->execute()
            ->fetchAll('assoc');

        return $results;
    }

    /**
     * update
     *
     * @param  array $where
     * @return int
     */
    public function update(array $where): int
    {
        $this->connect();
        $result = $this->db->update($this->table, $this->values, $where)->rowCount();

        return $result;
    }

    /**
     * delete
     *
     * @return int
     */
    public function delete(): int
    {
        $this->connect();
        $result = $this->db->delete($this->table, $this->values)->rowCount();

        return $result;
    }

    /**
     * deleteSensiveCamps
     *
     * @param  array $removeTheseCamps
     * @return array
     */
    public function deleteSensiveCamps(array $removeTheseCamps): array
    {
        $camps = $this->camps;

        foreach ($this->sensiveCamps as $sensiveCamp) {
            $index = array_search($sensiveCamp, $camps);
            if ($index !== false) {
                unset($camps[$index]);
            }
        }

        foreach ($removeTheseCamps as $removeThisCamp) {
            $index = array_search($removeThisCamp, $camps);
            if ($index !== false) {
                unset($camps[$index]);
            }
        }

        return $camps;
    }

    /**
     * formatCamps
     *
     * @return array
     */
    protected function formatInnerCamps($campsTable1, $campsTable2, $table2): array
    {
        $campsTable1Formated = [];
        $campsTable2Formated = [];

        // formatar campos da busca tabela 1
        foreach ($campsTable1 as $camp) {
            array_push($campsTable1Formated, "$this->table.$camp");
        }

        // formatar campos da busca tabela 2
        foreach ($campsTable2 as $camp) {
            array_push($campsTable2Formated, "$table2.$camp");
        }

        $campsTotal = array_merge($campsTable1Formated, $campsTable2Formated);

        return $campsTotal;
    }

}
