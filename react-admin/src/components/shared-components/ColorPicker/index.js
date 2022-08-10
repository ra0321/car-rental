import React, { useState, useEffect } from 'react';
import PropTypes from 'prop-types'
import { SketchPicker } from 'react-color';

const ColorPicker = props => {

	const { colorChange, color='' } = props

	const [visible, setVisible] = useState(false);
	const [pickerColor, setPickerColor] = useState(color)
	const [boxColor, setBoxColor] = useState(color)

	useEffect(() => {
		setBoxColor(color);
		setPickerColor(color)
	}, [color]);

	const onPickerDropdown = () => {
		setVisible(!visible)
	}

	const onColorChange = (value) => {
		const {rgb} = value
		const rgba = `rgb(${rgb.r}, ${rgb.g}, ${rgb.b}, ${rgb.a})`
		setBoxColor(rgba)
		setPickerColor(rgb)
		colorChange(value)
	}

	return (
		<div className="color-picker">
			<div className="color-picker-dropdown">
				<div className="color" style={{backgroundColor: boxColor ? boxColor : '#ffffff'}} onClick={onPickerDropdown} />
			</div>
			{
				visible && (
					<>
						<div className="color-picker-backdrop" onClick={onPickerDropdown}/>
						<SketchPicker color={pickerColor} onChange={onColorChange}/>
					</>
				)
			}
		</div>
	)
}

ColorPicker.propTypes = {
	color: PropTypes.string,
	colorChange: PropTypes.func
}


export default ColorPicker;
