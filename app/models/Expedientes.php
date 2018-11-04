<?php

class Expedientes extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $idexpedientes;

    /**
     *
     * @var string
     */
    public $nombrepaciente;

    /**
     *
     * @var string
     */
    public $telefono;

    /**
     *
     * @var string
     */
    public $direccion;

    /**
     *
     * @var string
     */
    public $fechanacimiento;

    /**
     *
     * @var string
     */
    public $tiposangre;

    /**
     *
     * @var string
     */
    public $sexo;

    /**
     *
     * @var string
     */
    public $estadocivil;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->setSource("expedientes");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'expedientes';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Expedientes[]|Expedientes|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Expedientes|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
