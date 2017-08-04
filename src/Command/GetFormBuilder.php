<?php namespace Anomaly\CategoryDiscountFilterExtension\Command;

use Anomaly\ConfigurationModule\Configuration\Form\ConfigurationFormBuilder;
use Anomaly\DiscountsModule\Discount\Contract\DiscountInterface;
use Anomaly\DiscountsModule\Filter\Contract\FilterInterface;
use Anomaly\DiscountsModule\Filter\Extension\FilterExtension;
use Anomaly\DiscountsModule\Filter\Extension\Form\FilterExtensionFormBuilder;
use Anomaly\DiscountsModule\Filter\Form\FilterFormBuilder;


/**
 * Class GetFormBuilder
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\CategoryDiscountFilterExtension\Command
 */
class GetFormBuilder
{

    /**
     * The discount interface.
     *
     * @var DiscountInterface
     */
    protected $discount;

    /**
     * The filter interface.
     *
     * @var FilterInterface
     */
    protected $filter;

    /**
     * The filter extension.
     *
     * @var FilterExtension
     */
    protected $extension;

    /**
     * Create a new GetFormBuilder instance.
     *
     * @param FilterExtension   $extension
     * @param DiscountInterface $discount
     * @param FilterInterface   $filter
     */
    public function __construct(
        FilterExtension $extension,
        DiscountInterface $discount,
        FilterInterface $filter = null
    ) {
        $this->discount  = $discount;
        $this->filter    = $filter;
        $this->extension = $extension;
    }

    /**
     * Handle the command.
     *
     * @param FilterExtensionFormBuilder $builder
     * @param FilterFormBuilder          $filter
     * @param ConfigurationFormBuilder   $configuration
     * @return FilterExtensionFormBuilder
     */
    public function handle(
        FilterExtensionFormBuilder $builder,
        FilterFormBuilder $filter,
        ConfigurationFormBuilder $configuration
    ) {
        $builder->addForm(
            'filter',
            $filter
                ->setDiscount($this->discount)
                ->setExtension($this->extension)
                ->setEntry($this->filter ? $this->filter->getId() : null)
        );

        $builder->addForm(
            'configuration',
            $configuration
                ->setEntry('anomaly.extension.category_discount_filter')
        );

        if ($this->filter) {
            $configuration->setScope($this->filter->getId());
        } else {
            $builder->on(
                'saved_filter',
                function () use ($filter, $configuration) {
                    $configuration->setScope($filter->getFormEntryId());
                }
            );
        }

        return $builder;
    }
}
