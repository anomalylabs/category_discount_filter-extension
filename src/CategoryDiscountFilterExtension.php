<?php namespace Anomaly\CategoryDiscountFilterExtension;

use Anomaly\CategoryDiscountFilterExtension\Command\GetColumnValue;
use Anomaly\CategoryDiscountFilterExtension\Command\GetFormBuilder;
use Anomaly\CategoryDiscountFilterExtension\Command\ValidateDiscountFilter;
use Anomaly\DiscountsModule\Discount\Contract\DiscountInterface;
use Anomaly\DiscountsModule\Filter\Contract\FilterInterface;
use Anomaly\DiscountsModule\Filter\Extension\FilterExtension;
use Anomaly\DiscountsModule\Filter\Extension\Form\FilterExtensionFormBuilder;

/**
 * Class CategoryDiscountFilterExtension
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\CategoryDiscountFilterExtension
 */
class CategoryDiscountFilterExtension extends FilterExtension
{

    /**
     * This extension provides the category
     * filter for the discounts module.
     *
     * @var string
     */
    protected $provides = 'anomaly.module.discounts::filter.category';

    /**
     * Return the form builder.
     *
     * @param DiscountInterface $discount
     * @param FilterInterface $filter
     * @return FilterExtensionFormBuilder
     */
    public function form(DiscountInterface $discount, FilterInterface $filter = null)
    {
        return $this->dispatch(new GetFormBuilder($this, $discount, $filter));
    }

    /**
     * Return the column value for the table.
     *
     * @param DiscountInterface $discount
     * @param FilterInterface $filter
     * @return string
     */
    public function column(DiscountInterface $discount, FilterInterface $filter)
    {
        return $this->dispatch(new GetColumnValue($this, $discount, $filter));
    }

    /**
     * Return if the filter matches or not.
     *
     * @param $target
     * @return string
     */
    public function matches($target)
    {
        return $this->dispatch(new ValidateDiscountFilter($this, $target));
    }
}
