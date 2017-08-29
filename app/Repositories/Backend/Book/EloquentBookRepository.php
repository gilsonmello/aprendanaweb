<?php namespace App\Repositories\Backend\Book;

use App\Exceptions\GeneralException;
use Carbon\Carbon;
use App\Book;

/**
 * Class EloquentBookRepository
 * @package App\Repositories\Book
 */
class EloquentBookRepository implements BookContract {

    public function __construct() {
            
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $book = Book::withTrashed()->find($id);

        if (!is_null($book))
            return $book;

        throw new GeneralException('Livro inexistente');
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $product = $this->createProductStub($input);
        if ($product->save()) {
            return true;
        }
        throw new GeneralException('There was a problem creating this product. Please try again.');
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createProductStub($input) {

        //Instância de um novo fornecedor
        $product = new Product;

        //Nome do fornecedor
        $product->suppliers_id = $input['suppliers_id'];

        if(isset($input['tags']) && count($input['tags']) > 0) {
            $input['tags'] = implode(';', $input['tags']);
        }

        //Contato do fornecedor
        $product->tags = (isset($input['tags']) && !empty($input['tags'])) ? $input['tags'] : NULL;

        //Telefone do fornecedor
        $product->description = (isset($input['description']) && !empty($input['description'])) ? $input['description'] : NULL;

        //Cidade do fornecedor
        $product->commission = (isset($input['commission']) && !empty($input['commission'])) ? $input['commission'] : NULL;

        //Estado do fornecedor
        $product->shipping_free = (isset($input['shipping_free']) && !empty($input['shipping_free'])) ? $input['shipping_free'] : NULL;

        //País do fornecedor
        $product->price = (isset($input['price']) && !empty($input['price'])) ? $input['price'] : NULL;

        $product->price_descount = (isset($input['price_descount']) && !empty($input['price_descount'])) ? $input['price_descount'] : NULL;

        $product->is_active = (isset($input['is_active']) && !empty($input['is_active'])) ? $input['is_active'] : NULL;

        return $product;
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
            
            //Fazendo busca do registro pelo ID
            $supplier = $this->findOrThrowException($id);

            //Nome do fornecedor
            $supplier->company_name = $input['company_name'];

            //Contato do fornecedor
            $supplier->contact = (isset($input['contact']) && !empty($input['contact'])) ? $input['contact'] : NULL;

            //Telefone do fornecedor
            $supplier->fone = (isset($input['fone']) && !empty($input['fone'])) ? $input['fone'] : NULL;

            //Cidade do fornecedor
            $supplier->city_id = (isset($input['city_id']) && !empty($input['city_id'])) ? $input['city_id'] : NULL;

            //Estado do fornecedor
            $supplier->state_id = (isset($input['state_id']) && !empty($input['state_id'])) ? $input['state_id'] : NULL;

            //País do fornecedor
            $supplier->country_id = (isset($input['country_id']) && !empty($input['country_id'])) ? $input['country_id'] : NULL;
            
            //Atualizando registro
            if($supplier->save()){
                    return true;
            }
            
            throw new GeneralException('There was a problem updating this fornecedor. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
            $supplier = $this->findOrThrowException($id);
            if ($supplier->delete())
                    return true;

            throw new GeneralException("There was a problem deleting this fornecedor. Please try again.");
    }

}
