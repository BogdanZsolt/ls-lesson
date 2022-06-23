import { __ } from '@wordpress/i18n';
import { TextControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { useEntityProp } from '@wordpress/core-data';
import { useBlockProps } from '@wordpress/block-editor';

export default function Edit() {
	const postType = useSelect((select) => {
		return select('core/editor').getCurrentPostType();
	}, []);
	const [meta, setMeta] = useEntityProp('postType', postType, 'meta');
	const videoUrl = meta._ls_lesson_video;

	const onVideoUrlChange = (value) => {
		setMeta({ ...meta, _ls_lesson_video: value });
	};

	return (
		<div {...useBlockProps()}>
			{videoUrl || videoUrl === '' ? (
				<TextControl
					label={__('Video Url', 'ls-lesson')}
					value={videoUrl}
					onChange={onVideoUrlChange}
				/>
			) : (
				__('Meta Field is Not Registered', 'ls-lesson')
			)}
		</div>
	);
}
