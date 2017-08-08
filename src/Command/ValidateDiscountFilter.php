<?php namespace Anomaly\CategoryDiscountFilterExtension\Command;

use Anomaly\CartsModule\Item\Contract\ItemInterface;
use Anomaly\CategoryDiscountFilterExtension\CategoryDiscountFilterExtension;
use Anomaly\ConfigurationModule\Configuration\Contract\ConfigurationRepositoryInterface;
use Anomaly\ProductsModule\Category\Contract\CategoryInterface;
use Anomaly\ProductsModule\Category\Contract\CategoryRepositoryInterface;
use Anomaly\ProductsModule\Configuration\Contract\ConfigurationInterface;

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
     * The extension instance.
     *
     * @var CategoryDiscountFilterExtension
     */
    private $extension;

    /**
     * The target object.
     *
     * @var mixed
     */
    private $target;

    /**
     * Create a new ValidateDiscountFilter instance.
     *
     * @param CategoryDiscountFilterExtension $extension
     * @param                                      $target
     */
    public function __construct(CategoryDiscountFilterExtension $extension, $target)
    {
        $this->extension = $extension;
        $this->target    = $target;
    }

    /**
     * Handle the command.
     *
     * @param CategoryRepositoryInterface $categories
     * @param ConfigurationRepositoryInterface $configuration
     * @return string
     */
    public function handle(CategoryRepositoryInterface $categories, ConfigurationRepositoryInterface $configuration)
    {

        /**
         * We have to have an item since categories
         * only exist on products via cart items.
         */
        if (!$this->target instanceof ItemInterface) {
            return false;
        }

        /**
         * We have to have a purchasable item
         * which should be a configuration.
         */
        if (!$purchasable = $this->target->getEntry()) {
            return false;
        }

        /**
         * Make sure we have the
         * interface we need,
         */
        if (!$purchasable instanceof ConfigurationInterface) {
            return false;
        }

        /* @var CategoryInterface $value */
        if (!$value = $categories->find(
            $configuration->value(
                'anomaly.extension.category_discount_filter::value',
                $this->extension->getFilter()->getId()
            )
        )
        ) {
            return false;
        }

        return $purchasable
            ->getProduct()
            ->getCategories()
            ->find($value);
    }
}
