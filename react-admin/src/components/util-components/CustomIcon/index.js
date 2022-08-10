import React from 'react'
import Icon from '@ant-design/icons';

const CustomIcon = React.forwardRef((props, _) => <Icon component={props.svg} className={props.className}/>)

export default CustomIcon
