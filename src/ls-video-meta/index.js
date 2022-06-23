import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import Edit from './edit';
import save from './save';

registerBlockType('ls-blocks/ls-video-meta', {
	title: __('LS Video Metabox', 'ls-lesson'),
	description: __('LS Video Meta Input Field.', 'ls-lesson'),
	keywords: ['la', 'saphire', 'video', 'meta', 'input'],
	icon: 'admin-users',
	supports: {
		html: false,
	},
	edit: Edit,
	save,
});
