function Header(props){
    return <div className="container">
        <nav className="navbar navbar-expand-lg bg-body-tertiary">
            <div className="container-fluid">
                <a className="navbar-brand" href="#">{props.content.companyName}</a>
                <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span className="navbar-toggler-icon"></span>
                </button>
                <div className="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul className="navbar-nav">
                        <li className="nav-item">
                            <a className="nav-link active" aria-current="page" href="#">{props.content.home}</a>
                        </li>
                        <li className="nav-item">
                            <a className="nav-link" href="#">{props.content.aboutCompany}</a>
                        </li>
                        <li className="nav-item">
                            <a className="nav-link" href="#">{props.content.price}</a>
                        </li>
                        <li className="nav-item dropdown">
                            <a className="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {props.content.another}
                            </a>
                            <ul className="dropdown-menu">
                                <li><a className="dropdown-item" href="#">{props.content.anotherContent.aboutUs}</a></li>
                                <li><a className="dropdown-item" href="#">{props.content.anotherContent.ourHistory}</a></li>
                                <li><a className="dropdown-item" href="#">{props.content.anotherContent.charity}</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
}

export default Header;