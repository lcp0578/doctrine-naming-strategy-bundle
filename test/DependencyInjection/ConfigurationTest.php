<?php
/*
 * This file is part of the Doctrine Naming Strategy Bundle, an RunOpenCode project.
 *
 * (c) 2017 RunOpenCode
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RunOpenCode\Bundle\DoctrineNamingStrategy\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionConfigurationTestCase;
use RunOpenCode\Bundle\DoctrineNamingStrategy\DependencyInjection\Configuration;
use RunOpenCode\Bundle\DoctrineNamingStrategy\DependencyInjection\Extension;

class ConfigurationTest extends AbstractExtensionConfigurationTestCase
{
    /**
     * @test
     */
    public function itHasReasonableDefaults()
    {
        $this->assertProcessedConfigurationEquals([
            'underscored_bundle_prefix' => [
                'case' => 'lowercase',
                'join_table_field_suffix' => true,
                'map' => [],
                'whitelist' => [],
                'blacklist' => [],
            ],
            'underscored_class_namespace_prefix' => [
                'case' => 'lowercase',
                'join_table_field_suffix' => true,
                'map' => [],
                'whitelist' => [],
                'blacklist' => [],
            ],
            'underscored_namer_collection' => [
                'default' => 'doctrine.orm.naming_strategy.underscore',
                'join_table_field_suffix' => true,
                'namers' => [
                    'runopencode.doctrine.orm.naming_strategy.underscored_class_namespace_prefix',
                    'runopencode.doctrine.orm.naming_strategy.underscored_bundle_prefix',
                ],
            ],
        ], [
            __DIR__ . '/../Fixtures/config/empty.xml'
        ]);
    }

    /**
     * @test
     */
    public function itCanBeProperlyConfigured()
    {
        $this->assertProcessedConfigurationEquals([
            'underscored_bundle_prefix' => [
                'case' => 'uppercase',
                'join_table_field_suffix' => false,
                'map' => [
                    'SomeBundle' => 'some_prefix',
                    'SomeOtherBundle' => 'some_other_prefix',
                ],
                'whitelist' => [],
                'blacklist' => [
                    'ExcludedBundle',
                ],
            ],
            'underscored_class_namespace_prefix' => [
                'case' => 'uppercase',
                'join_table_field_suffix' => false,
                'map' => [
                    'Some\Namespace' => 'some_prefix',
                    'Some\Other\Namespace' => 'some_other_prefix',
                ],
                'whitelist' => [
                    'Some\Namespace',
                    'Some\Other\Namespace',
                ],
                'blacklist' => [],
            ],
            'underscored_namer_collection' => [
                'default' => 'default_namer',
                'join_table_field_suffix' => false,
                'namers' => [
                    'first_namer',
                ],
            ],
        ], [
            __DIR__ . '/../Fixtures/config/full.xml'
        ]);
    }

    /**
     * @test
     */
    public function itCanBeProperlyConfiguredWithYaml()
    {
        $this->assertProcessedConfigurationEquals([
            'underscored_bundle_prefix' => [
                'case' => 'uppercase',
                'join_table_field_suffix' => false,
                'map' => [
                    'MyLongNameOfTheBundle' => 'my_prefix',
                    'MyOtherLongNameOfTheBundle' => 'my_prefix_2',
                ],
                'whitelist' => [],
                'blacklist' => [
                    'DoNotPrefixThisBundle',
                ],
            ],
            'underscored_class_namespace_prefix' => [
                'case' => 'uppercase',
                'join_table_field_suffix' => false,
                'map' => [
                    'My\Class\Namespace\Entity' => 'my_prefix',
                ],
                'whitelist' => [
                    'My\Class\Namespace\Entity\ThisShouldNotBeSkipped',
                    'My\Class\Namespace\Entity\ThisShouldNotBeSkippedAsWell',
                ],
                'blacklist' => [],
            ],
            'underscored_namer_collection' => [
                'default' => 'default_namer',
                'join_table_field_suffix' => false,
                'namers' => [
                    'a_namer',
                ],
            ],
        ], [
            __DIR__ . '/../Fixtures/config/full.yml'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtension()
    {
        return new Extension();
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        return new Configuration();
    }
}
