<?php
// app/code/Esgi/Helloworld/Block/Hello.php
namespace Esgi\Helloworld\Block;

/**
 * Hello block
 */
class Hello extends \Magento\Framework\View\Element\Template
{
    /**
     * @param string $name
     * @return string
     */
    public function hello(string $name): string
    {
        return 'Hello ' . $name;
    }
}
