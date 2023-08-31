function Card(props) {
    return <div className="col-md-6 mb-4">
        <div className="h-100 p-5 text-bg-dark rounded-3">
            <h2>{props.header}</h2>
            <p>{props.text}</p>
            <button className="btn btn-outline-light" type="button">{props.button}</button>
        </div>
    </div>
}

export default Card;