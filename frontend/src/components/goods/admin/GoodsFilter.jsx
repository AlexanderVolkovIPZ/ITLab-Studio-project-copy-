import React, {useEffect, useState} from "react";
import axios from "axios";
import {responseStatus} from "../../../utils/consts";
import {Helmet} from "react-helmet-async";
import {Breadcrumbs, FormControl, Link, TextField, Typography} from "@mui/material";
import {NavLink, useNavigate, useSearchParams} from "react-router-dom";
import GoodsList from "./GoodsList";
import {checkFilterItem, fetchFilterData} from "../../../utils/fetchFilterData";
import {LocalizationProvider} from "@mui/x-date-pickers/LocalizationProvider";
import {AdapterDayjs} from "@mui/x-date-pickers/AdapterDayjs";
import {DatePicker} from "@mui/x-date-pickers/DatePicker";

const GoodsFilter = ({filterData, setFilterData}) => {

    const onChangeFilterData = (event) => {
        event.preventDefault();
        let {name, value} = event.target
        // console.log(name,value)

        setFilterData({...filterData, [name]: value})
    };

    const onChangeFilterDate = (event)=>{
        console.log(event.target)
    }

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
                        defaultValue={filterData.name ?? ""}
                        onChange={onChangeFilterData}
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
                        defaultValue={filterData["price[gt]"] ?? 0}
                        onChange={onChangeFilterData}
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
                        defaultValue={filterData["price[lt]"] ?? 1000}
                        onChange={onChangeFilterData}
                        InputLabelProps={{
                            shrink: true,
                        }}
                    />
                    {/*<LocalizationProvider dateAdapter={AdapterDayjs}>*/}
                    {/*    <DatePicker*/}
                    {/*        name="date[gte]"*/}
                    {/*        label="Min-Date"*/}
                    {/*        onChange={onChangeFilterDate}*/}
                    {/*    />*/}
                    {/*</LocalizationProvider>*/}
                    {/*<LocalizationProvider dateAdapter={AdapterDayjs}>*/}
                    {/*    <DatePicker*/}
                    {/*        name="lte"*/}
                    {/*        label="Max-Date"*/}
                    {/*        onChange={onChangeFilterDate}*/}
                    {/*    />*/}
                    {/*</LocalizationProvider>*/}
                    <input type="datetime-local"
                           name="date[after]"
                           onChange={onChangeFilterData}/>
                    <input type="datetime-local"
                           name="date[before]"
                           onChange={onChangeFilterData}/>
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