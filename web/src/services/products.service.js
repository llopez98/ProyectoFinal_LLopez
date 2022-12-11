import apiService from './api.service';

class ProductService{
    GetAllProducts(){
        return apiService.get("proyecto_final_llopez/api/producto/leer.php", null).then((response) =>{
            return Promise.resolve(response);
        }).catch((error)=>{
            console.log(error);
        });
    }

    DeleteProduct(id){
        return apiService.delete("proyecto_final_llopez/api/producto/eliminar.php", {
            id: id
        }).then(() =>{
            return true;
        }).catch((error)=>{
            console.log(error);
            return false;
        });
    }

    EditProduct(item){
        return apiService.put("proyecto_final_llopez/api/producto/actualizar.php", item).then((response) =>{
            console.log(response.data);
            return true;
        }).catch((error)=>{
            console.log(error);
            return false;
        });
    }
}

export default new ProductService();