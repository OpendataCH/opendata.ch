wp.domReady( () => {
	wp.blocks.unregisterBlockStyle(
        'core/image', 
        ['default','rounded']
    );
    
	// wp.blocks.getBlockTypes().forEach((block) => {
	// 	if (_.isArray(block['styles'])) {
	// 		console.log(block.name, _.pluck(block['styles'], 'name'));
	// 	}
	// });    

	// wp.blocks.registerBlockStyle(
	// 	'core/button',
	// 	[
	// 		{
	// 			name: 'default',
	// 			label: 'Default',
	// 			isDefault: true,
	// 		},
	// 		{
	// 			name: 'full',
	// 			label: 'Full Width',
	// 		}
	// 	]
	// );

	// wp.blocks.unregisterBlockStyle(
	// 	'core/separator',
	// 	[ 'default', 'wide', 'dots' ],
	// );

	// wp.blocks.unregisterBlockStyle(
	// 	'core/quote',
	// 	[ 'default', 'large' ]
	// );
} );