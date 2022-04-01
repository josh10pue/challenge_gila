import axios from "axios";
import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import AsyncSelect from "react-select/async"

const endpoint = "http://challenge-backend.test/api/";


const CreateProduct = () => {
  const [categoryId, setCategoryId] = useState("");
  const [name, setName] = useState("");
  const [sku, setSku] = useState("");
  const [brand, setBrand] = useState("");
  const [text1, setText1] = useState("");
  const [textAttr1, setTextAttr1] = useState("");
  const [text2, setText2] = useState("");
  const [textAttr2, setTextAttr2] = useState("");
  const [attributeOne, setAttributeOne] = useState("");
  const [attributeTwo, setAttributeTwo] = useState("");
  const [categories, setCategories] = useState([]);
  const [price, setPrice] = useState(0);
  const [stock, setStock] = useState(0);

  const navigate = useNavigate();


  const fillSelect = async() => {

    const response = await axios.get(`${endpoint}categories`);
    setCategories( response.data );
    
  };

  useEffect(() => {

    fillSelect();

  }, [])

  const store = async (e) => {
    e.preventDefault();

    const response = await axios.post(`${endpoint}product`, {
                                "category_id": categoryId,
                                "name": name,
                                "sku": sku,
                                "brand": brand,
                                "price": price,
                                "stock": stock,
                                "attribute_1": textAttr1,
                                "attribute_1_value": attributeOne,
                                "attribute_2": textAttr2,
                                "attribute_2_value": attributeTwo
    })
    
    navigate('/')
  };

  const onDropdownChange = (e) => {
    const attributesObj = categories[e.target.value-1].attributes; 
    setCategoryId(e.target.value);
    attributesObj.map(( item, index ) => {
      
      if(index === 0){
        setText1(item.name);
        setTextAttr1(item.id);
      }else{
        setText2(item.name);
        setTextAttr2(item.id);
      }
      
    })
  }
  
  return (
    <div>
      <div className="container">
        <div className="row">
          <div className="col-12 text-center pb-3 pt-3">
            <h3>Create Product</h3>
          </div>
          <div className="col-12 text-start pb-3 pt-3 card">
            <form onSubmit={store}>
              <div className="row">
                <div className="col-sm-6">
                  <label className="form-label">Name</label>
                  <input
                    value={name}
                    onChange={(e) => setName(e.target.value)}
                    type="text"
                    className="form-control"
                  />
                </div>
                <div className="col-sm-6">
                  <label className="form-label">Brand</label>
                  <input
                    value={brand}
                    onChange={(e) => setBrand(e.target.value)}
                    type="text"
                    className="form-control"
                  />
                </div>
              </div>
              <div className="row">
                <div className="col-sm-4">
                  <label className="form-label">SKU</label>
                  <input
                    value={sku}
                    onChange={(e) => setSku(e.target.value)}
                    type="text"
                    className="form-control"
                  />
                </div>
                <div className="col-sm-4">
                  <label className="form-label">Price</label>
                  <input
                    value={price}
                    onChange={(e) => setPrice(e.target.value)}
                    type="text"
                    className="form-control"
                  />
                </div>
                <div className="col-sm-4">
                  <label className="form-label">Stock</label>
                  <input
                    value={stock}
                    onChange={(e) => setStock(e.target.value)}
                    type="text"
                    className="form-control"
                  />
                </div>
              </div>
              <div className="row">
                <div className="col-sm-12">
                  <label className="form-label">Category</label>
                  <select
                    className="form-select"
                    name="category_id"
                    onChange={onDropdownChange}
                  >
                    <option value="">Select category</option>
                    { categories.map((category, index) => (
                        <option key={index} value={category.id}>
                          {category.name}
                        </option>
                      )) }
                  </select>
                </div>
                <div className="col-sm-6">
                  <label className="form-label">{text1}</label>
                  <input
                    value={attributeOne}
                    onChange={(e) => setAttributeOne(e.target.value)}
                    type="text"
                    className="form-control"
                  />
                </div>
                <div className="col-sm-6">
                  <label className="form-label">{text2}</label>
                  <input
                    value={attributeTwo}
                    onChange={(e) => setAttributeTwo(e.target.value)}
                    type="text"
                    className="form-control"
                  />
                </div>
              </div>
              <br />
              <div className="row g-3">
                <div className="col-sm-6 pb-3">
                  <button type="submit" className="btn btn-primary mb-3">
                    Submit
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
};

export default CreateProduct;
