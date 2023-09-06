import React from "react";
import {createBrowserRouter, Link, Outlet, RouterProvider} from
        "react-router-dom";

let router = createBrowserRouter(
    [
        {
            path: "/", element: <>
                <div className="container">
                    <nav className="navbar navbar-expand-lg bg-body-tertiary">
                        <div className="container-fluid">

                            <a className="navbar-brand" href="#">{props.content.companyName}</a>
                            <button className="navbar-toggler" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                <span className="navbar-toggler-icon"></span>
                            </button>
                            <div className="collapse navbar-collapse" id="navbarNavDropdown">
                                <ul className="navbar-nav">
                                    <li className="nav-item">
                                        <Link to="/">{props.content.home}</Link>
                                        {/*<a className="nav-link active" aria-current="page" href="#">{props.content.home}</a>*/}
                                    </li>
                                    <li className="nav-item">
                                        <Link to="/about">{props.content.aboutCompany}</Link>
                                        {/*<a className="nav-link" href="#">{props.content.aboutCompany}</a>*/}
                                    </li>
                                    <li className="nav-item">
                                        <Link to="/price">{props.content.price}</Link>
                                        {/*<a className="nav-link" href="#">{props.content.price}</a>*/}
                                    </li>
                                    <li className="nav-item dropdown">
                                        <Link to="/another">{props.content.another}</Link>
                                        {/*<a className="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">*/}
                                        {/*    {props.content.another}*/}
                                        {/*</a>*/}
                                        <ul className="dropdown-menu">
                                            <li>
                                                <Link className="dropdown-item"
                                                      to="/about-us">{props.content.anotherContent.aboutUs}</Link>
                                                {/*<a className="dropdown-item" href="#">{props.content.anotherContent.aboutUs}</a>*/}
                                            </li>
                                            <li>
                                                <Link className="dropdown-item"
                                                      to="/history">{props.content.anotherContent.ourHistory}</Link>
                                                {/*<a className="dropdown-item" href="#">{props.content.anotherContent.ourHistory}</a>*/}
                                            </li>
                                            <li>
                                                <Link className="dropdown-item"
                                                      to="/charity">{props.content.anotherContent.charity}</Link>
                                                {/*<a className="dropdown-item" href="#">{props.content.anotherContent.charity}</a>*/}
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
                    {index: true, element: <><h1>Home</h1><p>Content</p></>},
                    {path: "about", element: <About/>},
                    {path: "contacts", element: <Contacts/>},
                    {path: "*", element: <NoMatch/>}
                ]

        }
    ]
)


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