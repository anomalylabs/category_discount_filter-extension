<?php namespace Anomaly\CategoryDiscountFilterExtension\Command;

use Anomaly\ConfigurationModule\Configuration\Contract\ConfigurationRepositoryInterface;
use Anomaly\DiscountsModule\Discount\Contract\DiscountInterface;
use Anomaly\DiscountsModule\Filter\Contract\FilterInterface;
use Anomaly\DiscountsModule\Filter\Extension\FilterExtension;
use Anomaly\ProductsModule\Category\Contract\CategoryInterface;
use Anomaly\ProductsModule\Category\Contract\CategoryRepositoryInterface;
use Illuminate\Translation\Translator;

/**
 * Class GetColumnValue
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\CategoryDiscountFilterExtension\Command
 */
class GetColumnValue
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
     * Create a new GetColumnValue instance.
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
     * @return string
     */
    public function handle(
        Translator $translator,
        CategoryRepositoryInterface $categories,
        ConfigurationRepositoryInterface $configuration
    ) {
        $scope = 'discount_' . $this->discount->getId() . '_' . $this->filter->getId();

        $operator = $configuration->presenter('anomaly.extension.category_discount_filter::operator', $scope)->value;

        /* @var CategoryInterface $value */
        if ($value = $categories->find(
            $configuration->value('anomaly.extension.category_discount_filter::value', $scope)
        )
        ) {
            $value = $value->getName();
        }

        return $translator->trans(
            'anomaly.extension.category_discount_filter::message.filter',
            compact('operator', 'value')
        );
    }
}
