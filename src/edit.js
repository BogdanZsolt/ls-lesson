import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { QueryControls, PanelBody } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import './editor.scss';

/* eslint-disable */
export default function Edit({ attributes, setAttributes }) {
	/* eslint-enable */
	const { numberOfPosts, order, orderBy } = attributes;

	const posts = useSelect((select) => {
		return select('core').getEntityRecords(
			'postType',
			'ls-lesson',
			{
				per_page: numberOfPosts,
				parent: 0,
				orderby: orderBy,
				order,
				status: 'publish',
				_embed: true,
			},
			[numberOfPosts]
		);
	});

	const onNumberOfItemsChange = (value) => {
		setAttributes({ numberOfPosts: value });
	};

	return (
		<>
			<InspectorControls>
				<PanelBody>
					<QueryControls
						numberOfItems={numberOfPosts}
						onNumberOfItemsChange={onNumberOfItemsChange}
						maxItems={10}
						minItems={-1}
						orderBy={orderBy}
						onOrderByChange={(value) =>
							setAttributes({ orderBy: value })
						}
						order={order}
						onOrderChange={(value) =>
							setAttributes({ order: value })
						}
					/>
				</PanelBody>
			</InspectorControls>
			<ul {...useBlockProps()}>
				{posts &&
					posts.map((post) => {
						const featuredImage =
							post._embedded &&
							post._embedded['wp:featuredmedia'] &&
							post._embedded['wp:featuredmedia'].length > 0 &&
							post._embedded['wp:featuredmedia'][0];
						return (
							<li key={post.id}>
								{featuredImage && (
									<img
										src={
											featuredImage.media_details.sizes
												.full.source_url
										}
										alt={featuredImage.alt_text}
									/>
								)}
								<h5>
									<a href={post.link}>
										{post.title.rendered}
									</a>
								</h5>
							</li>
						);
					})}
			</ul>
		</>
	);
}
