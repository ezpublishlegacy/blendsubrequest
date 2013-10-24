Blend Sub-request extension for eZ Publish 5.x
===============

What is this thing?
---------------

When you're building a site in eZ Publish 5, you can build out most of your templates using 
Twig. But since the admin interface still uses the legacy system, sometimes your old templates will
crop up. In particular, things like eZOE embeds and previews will render using the wrong templates. Also, you can't access any other Symfony bundles via subrequests like you can in your Twig templates.

So should you create all of your templates twice? No! This extension provides a template operator for legacy eZ Publish templates (*.tpl's) that lets you include the output of Symfony subrequests in your old-school templates.

How do I install it?
----------------

Just clone this repository into your legacy extensions folder (ezpublish_legacy/extensions/blendsubrequest). Then activate it by adding 'blendsubrequest' to your ActiveExtensions[] array in ezpublish_legacy/settings/override/site.ini.append.php

It should go without saying, but this extension will only work if you're running eZ Publish 5 via 
the Symfony stack.

How do I use it?
----------------

The syntax is similar to calling render(controller()) from a Twig template.
Add this to your legacy template: 

```
{ render_controller(<string: controller name>, <hash: named parameters>) }
```

For example, let's say you wanted to make your legacy full view template render your Twig full view template instead. You'd make a node/view/full.tpl on your legacy design that contains this: 

```
{ render_controller( 'ez_content:viewLocation', hash( 
	'locationId', $object.main_node_id, 
	'viewType', 'full'
)) }
```

Or maybe you want to re-use a navigation menu that you created using KNPMenuBundle:
```
{ render_controller( 'nav:primaryNav', hash( 
	'selectedItem', $node.main_node_id
)) }
```

In short, if you can call it via Twig's {{ render( controller() ) }}, you can call it in a legacy template.

How's the performance?
-------------------

It's OK. It's not great. Your rendering path will now go through Symfony, to the legacy system, and then back to Symfony. It's not that much worse than a standard sub-request.

The goal of this tool is to make it easier to build a fully-viable Twig-only 
design by bringing some of your Twig templates into the preview areas of the eZ Publish admin, 
allowing you to use preview features without re-work. This is a bridge technology for the current generation of 'dual-core' eZ Publish releases.



