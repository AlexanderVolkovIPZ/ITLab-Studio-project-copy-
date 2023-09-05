import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import reportWebVitals from './reportWebVitals';
import Counter from "./components/Counter";
import {BrowserRouter} from "react-router-dom";
import Header from "./components/Header";
import Footer from "./components/Footer";
import Navigation from "./components/Navigation";


let headerContent = {
    "companyName": "Новини України",
    "home": "Додому",
    "aboutCompany": "Про компанію",
    "price": "Ціни",
    "another": "Інше",
    "anotherContent": {
        "aboutUs": "Про нас",
        "ourHistory": "Наша історія",
        "charity": "Благодійність",
    }
};

const root = ReactDOM.createRoot(document.getElementById('root'));
const values = {
    "min": 0,
    "max": 20,
    "currentValue":10
}
root.render(
    <React.StrictMode>
        <BrowserRouter>
            <Header content={headerContent}/>
            <Navigation/>
            <Footer/>
        </BrowserRouter>
    </React.StrictMode>
);
reportWebVitals();
