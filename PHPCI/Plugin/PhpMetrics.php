<?php
/**
 * PHPCI - Continuous Integration for PHP
 *
 * @copyright    Copyright 2014, Block 8 Limited.
 * @license      https://github.com/Block8/PHPCI/blob/master/LICENSE.md
 * @link         https://www.phptesting.org/
 */
namespace PHPCI\Plugin;

use PHPCI;
use PHPCI\Builder;
use PHPCI\Model\Build;

/**
 * PhpMetrics plugin
 *
 * @package PHPCI\Plugin
 * @author marc aschmann <maschmann@gmail.com>
 */
class PhpMetrics implements PHPCI\Plugin, PHPCI\ZeroConfigPlugin
{

    /**
     * @var Builder
     */
    protected $phpci;

    /**
     * @var Build
     */
    protected $build;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var array
     */
    protected $metricsConfig;

    /**
     * Constructor
     *
     * @param Builder $phpci
     * @param Build $build
     * @param array $options
     */
    public function __construct(Builder $phpci, Build $build, array $options = array())
    {
        $this->phpci = $phpci;
        $this->build = $build;
        $this->options = $options;
    }

    /**
     *
     */
    public function execute()
    {
        // TODO: Implement execute() method.
    }

    /**
     * @param string $stage
     * @param Builder $builder
     * @param Build $build
     */
    public static function canExecute($stage, Builder $builder, Build $build)
    {
        // TODO: Implement canExecute() method.
    }

    protected function processMetrics()
    {

    }

    protected function resolveOptions()
    {

    }
}
