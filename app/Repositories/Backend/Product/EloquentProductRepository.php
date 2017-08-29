<?php namespace App\Repositories\Backend\Product;

use App\Supplier;
use App\City;
use App\State;
use App\Country;
use App\Exceptions\GeneralException;
use Carbon\Carbon;
use App\Product;
use App\Book;
use App\Repositories\Backend\Book\BookContract;

/**
 * Class EloquentProductRepository
 * @package App\Repositories\Product
 */
class EloquentProductRepository implements ProductContract {

    /**
     * @param BookContract $book
     *
    **/
    public function __construct(BookContract $book) {
        $this->book = $book;
    }

    /**
     * Função para retornar todas as cidades
     * @return mixed
     */
    public function getAllSuppliers() {
        return Supplier::suppliers();
    }

    /**
     * Função para retornar todos os estados
     * @return mixed
     */
    public function getAllStates() {
            return State::states();
    }

    /**
     * Função para retornar todos os países
     * @return mixed
     */
    public function getAllCountries() {
            return Country::countries();
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $product = Supplier::withTrashed()->find($id);

        if (!is_null($product))
            return $product;

        throw new GeneralException('Produto inexistente');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllSuppliersPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_NewsController_title = '') {
            return Supplier::where('company_name', 'like', '%' . $f_NewsController_title . '%')->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getProductsPaginated($per_page, $order_by = 'id', $sort = 'asc', $product_name = '') {
            return Product::where('title', 'like', '%' . $product_name . '%')->orderBy($order_by, $sort)->paginate($per_page);
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
        $product->supplier_id = $input['supplier_id'];

        //Nome do fornecedor
        $product->title = $input['title'];

        if(isset($input['tags']) && count($input['tags']) > 0) {
            $input['tags'] = implode(';', $input['tags']);
        }

        //Contato do fornecedor
        $product->tags = (isset($input['tags']) && !empty($input['tags'])) ? $input['tags'] : "";

        //Telefone do fornecedor
        $product->description = (isset($input['description']) && !empty($input['description'])) ? $input['description'] : NULL;

        //Cidade do fornecedor
        $product->commission = (isset($input['commission']) && !empty($input['commission'])) ? $input['commission'] : NULL;

        //Estado do fornecedor
        $product->shipping_free = (isset($input['shipping_free']) && !empty($input['shipping_free'])) ? $input['shipping_free'] : NULL;

        //País do fornecedor
        $product->price = (isset($input['price']) && !empty($input['price'])) ? $input['price'] : NULL;

        $product->discount_price = (isset($input['discount_price']) && !empty($input['discount_price'])) ? $input['discount_price'] : NULL;

        $product->is_active = (isset($input['is_active']) && !empty($input['is_active'])) ? $input['is_active'] : 0;

        try{
            if($product->save() && $input['type'] === 'Livro'){
                $book = new Book;
                $book->product_id = $product->id;
                $book->subject = $input['subject'];
                $book->author_id = isset($input['author_id']) && !empty($input['author_id']) ? $input['author_id'] : NULL;
                $book->author_name = isset($input['author_name']) && !empty($input['author_name']) ? $input['author_name'] : NULL;
                $book->pages = isset($input['pages']) && !empty($input['pages']) ? $input['pages'] : NULL;
                $book->isbn = isset($input['isbn']) && !empty($input['isbn']) ? $input['isbn'] : NULL;
                $book->slug = isset($input['slug']) && !empty($input['slug']) ? $input['slug'] : NULL;
                $book->dimensions = isset($input['dimensions']) && !empty($input['dimensions']) ? $input['dimensions'] : NULL;
                $book->edition = isset($input['edition']) && !empty($input['edition']) ? $input['edition'] : NULL;
                $book->stuff = isset($input['stuff']) && !empty($input['stuff']) ? $input['stuff'] : NULL;
                if($book->save()){
                    return $product;
                }
            }
        }catch(Exception $e){

        }
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
