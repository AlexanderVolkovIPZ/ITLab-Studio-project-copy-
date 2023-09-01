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
        "aboutUs":"Про нас",
        "ourHistory":"Наша історія",
        "charity":"Благодійність",
    }
};

const root = ReactDOM.createRoot(document.getElementById('root'));
const arr = [3,12,45,656,87,9, 50]
root.render(
    <React.StrictMode>
        {
            arr.map((value, index)=>
                <Counter key = {index} value = {value} color="brown"/>
            )
        }
    </React.StrictMode>
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
