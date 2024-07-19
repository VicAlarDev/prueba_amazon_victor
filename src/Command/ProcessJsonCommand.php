<?php

namespace App\Command;

use App\Entity\Feature;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'app:process-json',
    description: 'Process JSON, save products & features to the database.',
)]
class ProcessJsonCommand extends Command
{
    private $doctrine;
    private $params;

    public function __construct(ManagerRegistry $doctrine, ParameterBagInterface $params)
    {
        $this->doctrine = $doctrine;
        $this->params = $params;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $projectDir = $this->params->get('kernel.project_dir');
        $jsonFilePath = $projectDir . '/products.json';

        $jsonData = json_decode(file_get_contents($jsonFilePath), true);
        $items = $jsonData['SearchResult']['Items'];
        $totalItems = count($items);

        $io->progressStart($totalItems);
        $entityManager = $this->doctrine->getManager();
        $this->doctrine->getConnection()->getConfiguration()->setSQLLogger(null);
        $this->doctrine->getConnection()->beginTransaction();

        $productRepository = $entityManager->getRepository(Product::class);

        try {
            foreach ($items as $item) {
                $asin = $item['ASIN'];
                $existingProduct = $productRepository->findOneBy(['asin' => $asin]);

                if ($existingProduct) {
                    // Update existing product
                    $this->updateProductFromItem($existingProduct, $item);
                } else {
                    // Create new product
                    $product = $this->createProductFromItem($item);
                    $entityManager->persist($product);

                    foreach ($item['ItemInfo']['Features']['DisplayValues'] as $featureDescription) {
                        $feature = new Feature();
                        $feature->setDescription($featureDescription);
                        $feature->setProduct($product);
                        $entityManager->persist($feature);
                    }
                }

                $entityManager->flush();
                $entityManager->clear();
                $io->progressAdvance();
            }
            $this->doctrine->getConnection()->commit();
        } catch (\Exception $e) {
            $this->doctrine->getConnection()->rollBack();
            $io->error($e->getMessage());
            return Command::FAILURE;
        }

        $io->progressFinish();
        $io->success("Processed $totalItems products and saved to the database.");

        return Command::SUCCESS;
    }

    private function updateProductFromItem(Product $product, array $item): void
    {
        $product->setTitle($item['ItemInfo']['Title']['DisplayValue']);
        $product->setBrand($item['ItemInfo']['ByLineInfo']['Brand']['DisplayValue']);
        $product->setImageUrl($item['Images']['Primary']['Large']['URL']);
        $product->setDiscount($item['Offers']['Listings'][0]['Price']['Savings']['Percentage']);
        $product->setRating(mt_rand(900, 1000) / 100);
    }

    private function createProductFromItem(array $item): Product
    {
        $product = new Product();
        $product->setAsin($item['ASIN']);
        $product->setTitle($item['ItemInfo']['Title']['DisplayValue']);
        $product->setBrand($item['ItemInfo']['ByLineInfo']['Brand']['DisplayValue']);
        $product->setImageUrl($item['Images']['Primary']['Large']['URL']);
        $product->setDiscount($item['Offers']['Listings'][0]['Price']['Savings']['Percentage']);
        $product->setRating(mt_rand(900, 1000) / 100);
        return $product;
    }
}
