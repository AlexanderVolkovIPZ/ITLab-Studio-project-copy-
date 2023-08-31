import Aside from "./Aside/index"
import Section1 from "./Section1";
import Section2 from "./Section2/index";
import Card from "./Section2/Card/index";
import Section3 from "./Section3";
import Slider from "./Section3/Slider";
import Section4 from "./Section4";
import Advert from "./Section4/Advert";
function Main(props){
    return <div>
        {/*<Aside/>*/}
        <Section1/>
        <Section2>
            <Card header = {props.cardContent.header.card1} text = {props.cardContent.content.card1} button = {props.cardContent.buttonLabel}/>
            <Card header = {props.cardContent.header.card2} text = {props.cardContent.content.card2} button = {props.cardContent.buttonLabel}/>
            <Card header = {props.cardContent.header.card3} text = {props.cardContent.content.card3} button = {props.cardContent.buttonLabel}/>
            <Card header = {props.cardContent.header.card4} text = {props.cardContent.content.card4} button = {props.cardContent.buttonLabel}/>
        </Section2>
        <Section3>
            <Slider src = {props.src}/>
        </Section3>
        <Section4>
            <Advert/>
        </Section4>

    </div>
}

export default Main