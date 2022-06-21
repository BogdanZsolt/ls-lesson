import { registerBlockType } from '@wordpress/blocks';
import './style.scss';
import Edit from './edit';
import save from './save';

registerBlockType('ls-blocks/ls-lesson', {
	edit: Edit,
	save,
});
