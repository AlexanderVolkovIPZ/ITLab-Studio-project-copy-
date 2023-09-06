import React, {useEffect, useState} from "react";
import axios from "axios";
import {responseStatus} from "../../../utils/consts";
import {Helmet} from "react-helmet-async";
import {Breadcrumbs, Link, Typography} from "@mui/material";
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
            <label htmlFor="name">Name</label>
            <input id="name" type="text" name="name" defaultValue={filterData.name??""} onChange={onChangeFilterData}/>
        </div>
    </>
};

export default GoodsFilter;