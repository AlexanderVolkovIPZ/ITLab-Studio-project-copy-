import React, {useEffect, useState} from "react";
import axios from "axios";
import {responseStatus} from "../../../utils/consts";
import {Helmet} from "react-helmet-async";
import {Breadcrumbs, Button, FormControl, Link, TextField, Typography} from "@mui/material";
import {NavLink, useNavigate, useSearchParams} from "react-router-dom";
import GoodsList from "./GoodsList";
import {checkFilterItem, fetchFilterData} from "../../../utils/fetchFilterData";
import {LocalizationProvider} from "@mui/x-date-pickers/LocalizationProvider";
import {AdapterDayjs} from "@mui/x-date-pickers/AdapterDayjs";
import {DatePicker} from "@mui/x-date-pickers/DatePicker";
import SendIcon from "@mui/icons-material/Send";

const GoodsCreateForm = () => {

    const [formData, setFormData] = useState({
        "name":"",
        "count":0,
        "price":0,
        "img":"",
        "category":1,
        "user":1,
        "date":new Date().getDate()
    })
    const onSubmitForm= (event)=>{
        event.preventDefault();
        axios.post("/api/product-create",{
            "name": "testProduct123",
            "count": 1,
            "price": "1",
            "imgName": "123",
            "date": "2023-09-07 18:01:53",
            "category": "1",
            "user": "1"
            // "name":formData.name,
            // "count":formData.count,
            // "price":formData.price,
            // "imgName":formData.img,
            // "date":formData.date,
            // "category":formData.category,
            // "user":formData.user
        },{
            "headers": {
                "Authorization": "Bearer " + localStorage.getItem("token"),
                "Content-type": "application/json+ld",
            }
        }).catch(error => {
            console.log(error);
        });
    };

    return <>
        <FormControl
            component="form"
            sx={{
                '& .MuiTextField-root': { m: 1, width: '25ch' },
                border: '1px solid #ccc', // Любой цвет и стиль обводки, который вам нужен
                borderRadius: '8px', // Настройте скругление углов, если необходимо
                padding: '16px', // Добавьте отступ для контента внутри формы

            }}
            noValidate
            autoComplete="off"
            name="formProductSubmit"
            onSubmit={(event)=>onSubmitForm(event)}
            style={{marginTop:"6px"}}
        >
            <Typography variant="h6" gutterBottom>
                Додавання продукта
            </Typography>
            <div>
                <TextField
                    required
                    id="name"
                    name="name"
                    label="Name"
                    onChange={(e)=>setFormData({...formData, name: e.target.value})}
                />
                <TextField
                    required
                    id="count"
                    name="count"
                    label="Count"
                    type="number"
                    InputLabelProps={{
                        shrink: true,
                    }}
                    onChange={(e)=>setFormData({...formData, count: e.target.value})}
                />
                <TextField
                    required
                    id="number"
                    number="number"
                    label="Price"
                    name="price"
                    type="number"
                    InputLabelProps={{
                        shrink: true,
                    }}
                    onChange={(e)=>setFormData({...formData, price: e.target.value})}
                />
                <TextField
                    required
                    id="img"
                    name="img"
                    label="Image name"
                    onChange={(e)=>setFormData({...formData, img: e.target.value})}
                />
                <TextField
                    required
                    id="category"
                    name="category"
                    label="Category id"
                    type="number"
                    InputLabelProps={{
                        shrink: true,
                    }}
                    onChange={(e)=>setFormData({...formData, category: e.target.value})}
                />
                <TextField
                    required
                    id="user"
                    name="user"
                    label="User id"
                    type="number"
                    InputLabelProps={{
                        shrink: true,
                    }}
                    onChange={(e)=>setFormData({...formData, user: e.target.value})}
                />
                <LocalizationProvider dateAdapter={AdapterDayjs}>
                    <DatePicker
                        name="date"
                        onChange={(selectedDate)=>setFormData({...formData, date: selectedDate})}
                    />
                </LocalizationProvider>
                <Button variant="contained" type="submit" endIcon={<SendIcon/>} size="string" style={{display:"flex", height:"56px", marginTop:"8px", marginLeft:"8px"}}>
                    Send
                </Button>
            </div>
        </FormControl>
    </>

};

export default GoodsCreateForm;