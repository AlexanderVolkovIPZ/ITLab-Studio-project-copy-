import React from "react";
import {createBrowserRouter, Link, Outlet, RouterProvider} from
        "react-router-dom";
import Counter from "../Counter";
import Home from "../Home";
import Price from "../Price";

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

let router = createBrowserRouter(
    [
        {
            path: "/", element: <>
                <div className="container">
                    <nav className="navbar navbar-expand-lg bg-body-tertiary">
                        <div className="container-fluid">

                            {/* <a className="navbar-brand" href="#">{props.content.companyName}</a>*/}
                            <button className="navbar-toggler" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                <span className="navbar-toggler-icon"></span>
                            </button>
                            <div className="collapse navbar-collapse" id="navbarNavDropdown">
                                <ul className="navbar-nav">
                                    <li className="nav-item">
                                        <Link className="nav-link active" aria-current="page"
                                              to="/">{headerContent.home}</Link>
                                    </li>
                                    <li className="nav-item">
                                        <Link className="nav-link" to="/about">{headerContent.aboutCompany}</Link>
                                    </li>
                                    <li className="nav-item">
                                        <Link className="nav-link" to="/price">{headerContent.price}</Link>
                                    </li>
                                    <li className="nav-item dropdown">
                                        <Link className="nav-link dropdown-toggle" to="#" role="button"
                                              data-bs-toggle="dropdown"
                                              aria-expanded="false">{headerContent.another}</Link>
                                        <ul className="dropdown-menu">
                                            <li>
                                                <Link className="dropdown-item"
                                                      to="/about-us">{headerContent.anotherContent.aboutUs}</Link>
                                            </li>
                                            <li>
                                                <Link className="dropdown-item"
                                                      to="/history">{headerContent.anotherContent.ourHistory}</Link>
                                            </li>
                                            <li>
                                                <Link className="dropdown-item"
                                                      to="/charity">{headerContent.anotherContent.charity}</Link>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
                <Outlet/>
            </>,
            children:
                [
                    {index: true, element: <Home/>},
                    {path: "about", element: <Counter min={0} max={10} value={1}/>},
                    {path: "price", element: <Price/>},
                    {path: "another", element: <Counter/>},
                    {path: "*", element: <Counter/>}
                ]

        }
    ]
)
export default function Header() {
    return (<RouterProvider router={router}/>)
}

// function Header(props){
//     return <div className="container">
//         <nav className="navbar navbar-expand-lg bg-body-tertiary">
//             <div className="container-fluid">
//                 <a className="navbar-brand" href="#">{props.content.companyName}</a>
//                 <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
//                     <span className="navbar-toggler-icon"></span>
//                 </button>
//                 <div className="collapse navbar-collapse" id="navbarNavDropdown">
//                     <ul className="navbar-nav">
//                         <li className="nav-item">
//                             <a className="nav-link active" aria-current="page" href="#">{props.content.home}</a>
//                         </li>
//                         <li className="nav-item">
//                             <a className="nav-link" href="#">{props.content.aboutCompany}</a>
//                         </li>
//                         <li className="nav-item">
//                             <a className="nav-link" href="#">{props.content.price}</a>
//                         </li>
//                         <li className="nav-item dropdown">
//                             <a className="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
//                                 {props.content.another}
//                             </a>
//                             <ul className="dropdown-menu">
//                                 <li><a className="dropdown-item" href="#">{props.content.anotherContent.aboutUs}</a></li>
//                                 <li><a className="dropdown-item" href="#">{props.content.anotherContent.ourHistory}</a></li>
//                                 <li><a className="dropdown-item" href="#">{props.content.anotherContent.charity}</a></li>
//                             </ul>
//                         </li>
//                     </ul>
//                 </div>
//             </div>
//         </nav>
//     </div>
// }
//
// export default Header;