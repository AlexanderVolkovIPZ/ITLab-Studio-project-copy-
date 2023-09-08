import React, {useEffect, useState} from "react";
import axios from "axios";
import {responseStatus} from "../../../utils/consts";
import {Helmet} from "react-helmet-async";
import {Breadcrumbs, FormControl, Link, TextField, Typography} from "@mui/material";
import {NavLink, useNavigate, useSearchParams} from "react-router-dom";
import GoodsList from "./GoodsList";
import {checkFilterItem, fetchFilterData} from "../../../utils/fetchFilterData";
import {LocalizationProvider} from '@mui/x-date-pickers/LocalizationProvider';
import dayjs from "dayjs";
import {DemoItem} from "@mui/x-date-pickers/internals/demo";
import {DateTimePicker} from "@mui/x-date-pickers";
import {AdapterDayjs} from "@mui/x-date-pickers/AdapterDayjs";

const GoodsFilter = ({filterData, setFilterData}) => {

    const onChangeFilterData = (event) => {
        event.preventDefault();
        let {name, value} = event.target
        setFilterData({...filterData, [name]: value})
    };

    const onChangeFilterDate = (event) => {
      console.log(event)
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
                    <input type="datetime-local"
                           name="date[after]"
                           onChange={onChangeFilterData}/>
                    <input type="datetime-local"
                           name="date[before]"
                           onChange={onChangeFilterData}/>
                </div>
            </FormControl>
        </div>
    </>
};

export default GoodsFilter;