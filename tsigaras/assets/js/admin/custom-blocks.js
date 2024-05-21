document.addEventListener('DOMContentLoaded', function () {
  const { registerBlockType } = wp.blocks;
  const { RichText } = wp.editor;

  registerBlockType('tsigaras/overview', {
    title: 'Tsigaras Overview',
    category: 'common',
    icon: 'media-text',
    description: 'Learning in progress',
    keywords: ['example', 'test'],
    attributes: {
      title: {
        type: 'string',
        source: 'html',
        selector: 'h5',
      },
      content: {
        type: 'string',
        source: 'html',
        selector: 'p',
      },
    },
    edit: function (props) {
      const { attributes, setAttributes } = props;
      const { title, content } = attributes;

      const onChangeTitle = (newTitle) => {
        setAttributes({ title: newTitle });
      };

      const onChangeContent = (newContent) => {
        setAttributes({ content: newContent });
      };

      return wp.element.createElement(
        'div',
        null,
        wp.element.createElement(
          RichText,
          {
            tagName: 'h5',
            value: title,
            onChange: onChangeTitle,
            placeholder: 'Enter title...',
          }
        ),
        wp.element.createElement(
          RichText,
          {
            tagName: 'p',
            value: content,
            onChange: onChangeContent,
            placeholder: 'Enter content...',
          }
        )
      );
    },
    save: function (props) {
      const { attributes } = props;
      const { title, content } = attributes;

      return wp.element.createElement(
        'div',
        null,
        wp.element.createElement(
          'h5',
          null,
          title
        ),
        wp.element.createElement(
          'p',
          null,
          content
        )
      );
    },
  });
});
