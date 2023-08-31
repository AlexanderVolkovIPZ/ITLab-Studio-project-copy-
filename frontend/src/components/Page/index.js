import "./style.css"
import Header from "../Header/index";
import Footer from "../Footer/index";
import Main from "../Main/index";
function Page(props){
    return <div>
        <Header content={props.header}/>
        <Main cardContent = {props.cardContent} src = {props.sliderSrc}/>
        <Footer/>
    </div>
}

export default Page