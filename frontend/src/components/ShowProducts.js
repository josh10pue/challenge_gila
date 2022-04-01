import React, { useEffect, useState } from 'react'
import axios from 'axios'
import { Link } from 'react-router-dom'

const endpoint = 'http://challenge-backend.test/api'

const ShowProducts = () => {
    
    const [products, setProducts] = useState( [] );

    useEffect(() => {
        
        getAllProducts();
        
    }, [])

    const getAllProducts = async() => {
        const response = await axios.get(`${endpoint}/products`);
        setProducts(response.data);
    }

    const deleteProduct = async(id) => {
        await axios.delete(`${endpoint}/product/${id}`);
        getAllProducts();
    }
    
  return (
    <div>
        <div className="container">
            <div className="row">
                <div className="col-12 text-center pb-3 pt-3">
                    <h3>Product warehouse</h3>
                </div>
                <div className="col-12 text-end pb-3">
                    <div className="d-grid gap-2 d-md-block">
                        <Link to="/create" className='btn btn-success btn-lg mt-2 text-white'>New Product</Link> 
                    </div>
                </div>
                <div className="col-12">
                    <table className='table table-striped'>

                        <thead className='bg-primary text-white'>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Details</th>
                                <th>SKU</th>
                                <th>Brand</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Options</th>
                            </tr>
                        </thead>

                        <tbody>
                            { products.map( ( product ) => (
                                <tr key={product.id}>
                                    <td> {product.name} </td>
                                    <td> 
                                        {product.category} 
                                    </td>
                                    <td>
                                    {product.attributes.map((attribute, index)=> (
                                        <p key={index}>{attribute.value}</p>
                                    ))}
                                    </td>
                                    <td> {product.sku} </td>
                                    <td> {product.brand} </td>
                                    <td> {product.price} </td>
                                    <td> {product.stock} </td>
                                    <td>
                                        <Link to={`/edit/${product.id}`} className='btn btn-warning'>Edit</Link>
                                        <button onClick={() => deleteProduct( product.id ) } className='btn btn-danger'>Delete</button>
                                    </td>
                                </tr>
                            )) }
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
  )

}

export default ShowProducts
