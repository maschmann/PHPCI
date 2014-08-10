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
 * PhpMetrics plugin.
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
     * @var array
     */
    protected $configWhitelist;

    /**
     * Constructor.
     *
     * @param Builder $phpci
     * @param Build $build
     * @param array $options
     */
    public function __construct(Builder $phpci, Build $build, array $options = array())
    {
        $this->phpci = $phpci;
        $this->build = $build;
        $this->options = $this->resolveOptions($options);
        $this->metricsConfig = array(
            '--report-json'    => 'php://stdout',
            '--quiet'          => null, // important, keeps output restricted to json
            '--no-interaction' => null, //failsafe
            '--extensions'     => 'php',
        );

        $this->configWhitelist = array(
            'exclude-dirs'      => '--excludeDirs',
            'failure-condition' => '--failure-condition',
            'path'              => '',
        );
    }

    /**
     * @inheritdoc
     */
    public function execute()
    {
        list($ignore, $standard, $suffixes) = $this->options;

        $phpcs = $this->phpci->findBinary('phpmetrics');

        if (!$phpcs) {
            $this->phpci->logFailure('Could not find phpcs.');
            return false;
        }

        $this->phpci->logExecOutput(false);

        $cmd = $phpcs . ' --report=json %s %s %s %s %s "%s"';
        $this->phpci->executeCommand(
            $cmd
        );

        $output = $this->phpci->getLastOutput();
        list($errors, $warnings, $data) = $this->processMetrics($output);

        $this->phpci->logExecOutput(true);
        $this->build->storeMeta('phpmetrics-data', $data);

        return true;
    }

    /**
     * @inheritdoc
     */
    public static function canExecute($stage, Builder $builder, Build $build)
    {
        // TODO: Implement canExecute() method.
    }

    /**
     * @param mixed $output
     * @return array
     */
    protected function processMetrics($output)
    {
        $errors = array();
        $warnings = array();
        $data = array();


        return array(
            $errors,
            $warnings,
            $data
        );
    }

    /**
     * Resolve the final configuration from user config and given defaults.
     *
     * @param array $options
     * @return array
     */
    protected function resolveOptions($options)
    {
        $resolvedOptions = array();
        foreach ($options as $param => $value) {
            // level values
            if (empty($value)) {
                $value = null;
            }

            $resolvedOptions['--' . $param] = $value;
        }

        $config = array_replace_recursive(
            $this->metricsConfig,
            $resolvedOptions
        );

        return $config;
    }

    /**
     * Create string representation of options for commandline call.
     *
     * @return string
     */
    protected function resolveOptionsString()
    {
        $options = '';
        foreach ($this->options as $param => $value) {
            if (empty($param)) {
                $options .= $param . ' ';
            } else {
                $options .= $param . '="' . $value . '" ';
            }
        }

        return $options;
    }
}
