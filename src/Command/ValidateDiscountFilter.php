<?php namespace Anomaly\CategoryDiscountFilterExtension\Command;

use Anomaly\ConfigurationModule\Configuration\Contract\ConfigurationRepositoryInterface;
use Anomaly\DiscountsModule\Discount\Contract\DiscountInterface;
use Anomaly\DiscountsModule\Filter\Contract\FilterInterface;
use Anomaly\ProductsModule\Category\Contract\CategoryInterface;
use Anomaly\ProductsModule\Category\Contract\CategoryRepositoryInterface;
use Anomaly\ProductsModule\Product\Contract\ProductInterface;

/**
 * Class ValidateDiscountFilter
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\CategoryDiscountFilterExtension\Command
 */
class ValidateDiscountFilter
{

    /**
     * The filter interface.
     *
     * @var FilterInterface
     */
    protected $filter;

    /**
     * The product instance.
     *
     * @var ProductInterface
     */
    protected $product;

    /**
     * The discount interface.
     *
     * @var DiscountInterface
     */
    protected $discount;

    /**
     * Create a new ValidateDiscountFilter instance.
     *
     * @param ProductInterface  $product
     * @param FilterInterface   $filter
     * @param DiscountInterface $discount
     */
    public function __construct(ProductInterface $product, FilterInterface $filter, DiscountInterface $discount)
    {
        $this->filter   = $filter;
        $this->product  = $product;
        $this->discount = $discount;
    }

    /**
     * Handle the command.
     *
     * @param CategoryRepositoryInterface      $categories
     * @param ConfigurationRepositoryInterface $configuration
     * @return string
     */
    public function handle(CategoryRepositoryInterface $categories, ConfigurationRepositoryInterface $configuration)
    {
        /* @var CategoryInterface $value */
        if (!$value = $categories->find(
            $configuration->value('anomaly.extension.category_discount_filter::value', $this->filter->getId())
        )
        ) {
            return false;
        }

        $categories = $this->product->getCategories();

        return $categories->has($value->getId());
    }
}
