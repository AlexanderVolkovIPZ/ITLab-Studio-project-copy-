import Counter from "../Counter";
import {Link, Route, Routes} from "react-router-dom";
import React from "react";

function Navigation() {
    const values = {
        "min": 0,
        "max": 20,
        "currentValue": 10
    }
    return <div className="container">
        <ul className="d-flex ">
            <li><Link to="/" className="mx-5">Home</Link></li>
            <li><Link to="/counter1">Counter1</Link></li>
        </ul>
        <Routes>
            <Route path="/" element={<>
                <h1>Home</h1>
                <p>Homepage content</p>
            </>}
            />
            <Route path="/counter1"
                   element={<Counter min={values.min} max={values.max} value={values.currentValue} color="green"/>}/>
            <Route path="/couner1/:id" element={<Counter min={values.min} max={values.max} value={values.currentValue} color="green"/>}/>
        </Routes>
    </div>
}


export default Navigation;