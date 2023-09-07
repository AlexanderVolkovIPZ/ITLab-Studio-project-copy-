import React, {useEffect, useState} from "react";
import axios from "axios";
import {responseStatus} from "../../../utils/consts";
import {Helmet} from "react-helmet-async";
import {Breadcrumbs, FormControl, Link, TextField, Typography} from "@mui/material";
import {NavLink, useNavigate, useSearchParams} from "react-router-dom";
import GoodsList from "./GoodsList";
import {checkFilterItem, fetchFilterData} from "../../../utils/fetchFilterData";

const GoodsFilter = ({filterData, setFilterData}) => {

    const onChangeFilterData = (event) => {
        event.preventDefault();
        let {name, value} = event.target

        setFilterData({...filterData, [name]: value})
    };

    return <>
        <div>
            <FormControl
                sx={{
                    '& .MuiTextField-root': {m: 1, width: '25ch'},
                    border: '1px solid #ccc',
                    borderRadius: '8px',
                    padding: '16px',
                }}
                noValidate
                autoComplete="off"
                name="formProductSubmit"
            >
                <Typography variant="h6" gutterBottom>
                    Фільтра продукта
                </Typography>
                <div>
                    <TextField
                        required
                        id="name"
                        name="name"
                        label="Name"
                        defaultValue={filterData.name ?? ""} onChange={onChangeFilterData}
                        InputLabelProps={{
                            shrink: true,
                        }}
                    />
                    <TextField
                        required
                        id="minPrice"
                        name="price[gt]"
                        label="Min-Price"
                        type="number"
                        defaultValue={filterData["price[gt]"] ?? 0} onChange={onChangeFilterData}
                        InputLabelProps={{
                            shrink: true,
                        }}
                    />
                    <TextField
                        required
                        id="maxPrice"
                        name="price[lt]"
                        label="Max-Price"
                        type="number"
                        defaultValue={filterData["price[lt]"] ?? 1000} onChange={onChangeFilterData}
                        InputLabelProps={{
                            shrink: true,
                        }}
                    />
                </div>


                {/*        <label htmlFor="minPrice">MinPrice</label>
            <input id="name" type="text" name="minPrice" defaultValue={filterData.name??""} onChange={onChangeFilterData}/>
            <label htmlFor="maxPrice">maxPrice</label>
            <input id="name" type="text" name="maxPrice" defaultValue={filterData.name??""} onChange={onChangeFilterData}/>*/}
            </FormControl>
        </div>
    </>
};

export default GoodsFilter;