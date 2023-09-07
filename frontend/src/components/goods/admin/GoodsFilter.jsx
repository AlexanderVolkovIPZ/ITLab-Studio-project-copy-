import React, {useEffect, useState} from "react";
import axios from "axios";
import {responseStatus} from "../../../utils/consts";
import {Helmet} from "react-helmet-async";
import {Breadcrumbs, FormControl, Link, TextField, Typography} from "@mui/material";
import {NavLink, useNavigate, useSearchParams} from "react-router-dom";
import GoodsList from "./GoodsList";
import {checkFilterItem, fetchFilterData} from "../../../utils/fetchFilterData";

const GoodsFilter = ({filterData, setFilterData}) => {

    const onChangeFilterData = (event)=>{
        event.preventDefault();
        let {name, value} = event.target

        setFilterData({...filterData, [name]:value})
    };

    return <>
        <div>
            <FormControl
                sx={{
                    '& .MuiTextField-root': { m: 1, width: '25ch' },
                    border: '1px solid #ccc', // Любой цвет и стиль обводки, который вам нужен
                    borderRadius: '8px', // Настройте скругление углов, если необходимо
                    padding: '16px', // Добавьте отступ для контента внутри формы

                }}
                noValidate
                autoComplete="off"
                name="formProductSubmit"
            >
                <Typography variant="h6" gutterBottom>
                    Фільтра продукта
                </Typography>
            <TextField
                required
                id="name"
                name="name"
                label="Name"
                defaultValue={filterData.name??""} onChange={onChangeFilterData}
            />
        {/*    <TextField
                required
                id="count"
                name="count"
                label="Count"
                type="number"
                InputLabelProps={{
                    shrink: true,
                }}
                onChange={(e)=>setFormData({...formData, count: e.target.value})}
            />*/}
    {/*        <label htmlFor="minPrice">MinPrice</label>
            <input id="name" type="text" name="minPrice" defaultValue={filterData.name??""} onChange={onChangeFilterData}/>
            <label htmlFor="maxPrice">maxPrice</label>
            <input id="name" type="text" name="maxPrice" defaultValue={filterData.name??""} onChange={onChangeFilterData}/>*/}
            </FormControl>
        </div>
    </>
};

export default GoodsFilter;