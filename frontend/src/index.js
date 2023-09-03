import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import reportWebVitals from './reportWebVitals';
import Counter from "./components/Counter";


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
        {
            <Counter min = {values.min} max = {values.max} value={values.currentValue} color="green"/>
        }
    </React.StrictMode>
);
reportWebVitals();
