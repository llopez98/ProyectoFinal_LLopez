import apiService from './api.service';

class ProductService{
    GetAllProducts(){
        return apiService.get("productos/leer", null).then((response) =>{
            return Promise.resolve(response);
        }).catch((error)=>{
            console.log(error);
        });
    }

    DeleteProduct(id){
        return apiService.delete("productos/eliminar", {
            id: id
        }).then(() =>{
            return true;
        }).catch((error)=>{
            console.log(error);
            return false;
        });
    }

    EditProduct(item){
        return apiService.put("product/", item).then(() =>{
            return true;
        }).catch((error)=>{
            console.log(error);
            return false;
        });
    }
}

export default new ProductService();