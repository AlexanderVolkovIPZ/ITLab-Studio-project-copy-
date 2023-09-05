import {useEffect, useState} from "react"
import styled, {css} from "styled-components";
import PropTypes from "prop-types";

let ValueStyled = styled.div`
  font-size: 30px;
  font-weight: bold;
  ${({min, max, value}) => {
    if (min > value || max < value) {
      return `color:red;`;
    } else {
      return `color:green;`;
    }
  }}
`

let ButtonsWrapper = styled.div`
  display: inline-block;
    & input{
      font-size: 30px;
      display: inline-block;
      width: 50px;
      height: 50px;
    }
  & input:nth-child(1){
    background-color: yellow;
  }
  & input:last-child{
    background-color: deepskyblue;
  }
`

let ContentWrapper = styled.div`
  margin: auto;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
`

function Counter({value = 20, padding = 20, color = "green", min = -100, max = 100}) {
    const [currentValue, setCurrentValue] = useState(value || 0)
    useEffect(() => {
        console.log("Mount ")
        return ()=>{
            console.log("Unmounted")
        };
    }, []);
    const updateStyle = () => {
        const style = window.getComputedStyle(document.getElementById("value"));
        if (style.color === "red") {
            return "green";
        } else {
            return "red";
        }
    };

    const handleIncrement = () => {
        let valueStyled = document.getElementById('value');
        let valueIncrement = currentValue + 1
        setCurrentValue(valueIncrement)
        valueStyled.style.color = valueIncrement < min || valueIncrement > max ? "red" : "green";
    }
    const decrementIncrement = () => {
        let valueStyled = document.getElementById('value');
        let valueDecrement = currentValue - 1
        setCurrentValue(valueDecrement)
        valueStyled.style.color = valueDecrement < min || valueDecrement > max ? "red" : "green";
    }

    return <ContentWrapper style={{padding, color: color}}>
        <ValueStyled min={min} max={max} value={value} id="value">Value {currentValue}</ValueStyled>
        <ButtonsWrapper>
            <input type="button" value="+" onClick={handleIncrement}/>
            <input type="button" value="-" onClick={decrementIncrement}/>
        </ButtonsWrapper>
    </ContentWrapper>
}

export default Counter