import {useState} from "react"
import PropTypes from "prop-types";
function Counter({value = 20, padding = 20, color = "red"}){
    const [currentValue,setCurrentValue]= useState(value||0)
    return <div style={{padding, color:color}}>
        <div>Value {currentValue}</div>
        <div>
            <button onClick={()=>setCurrentValue(currentValue+1)}>+</button>
            <button onClick={()=>setCurrentValue(currentValue-1)}>-</button>
        </div>
    </div>
}

/*Counter.defaultProps = {
    value:100
}*/
export default Counter