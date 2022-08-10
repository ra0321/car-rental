import React, { useState, useEffect } from "react";
import Markdown from 'react-markdown';
import CodeBox from './CodeBox';

const DemoCard = props => {

  const { code, children } = props
  const enUs = 'en-US: '
  const [markdown, setMarkdown] = useState('')

  useEffect(() => {
    let isMounted = true; 
    fetch(code).then(res => res.text()).then(
      md => {
        if(isMounted) {
          setMarkdown(md)
        }
      }
    );
    return () => { isMounted = false }; 
  }, [code]);

  return (
    <div className="code-box">
      <section className="code-box-demo">
        {children}
      </section>
      <section className="code-box-description">
        <Markdown
          source={markdown}
          renderers={
            {
              heading: h => (
                <h4>
                  {h.children[0].props.value.includes(enUs)? h.children[0].props.value.replace(enUs, '') : ''}
                </h4>
              ),
              thematicBreak : () => (
                <></>
              ),
              paragraph: p => (
                <>
                  {p.children[0].props.value.match(/[\u4e00-\u9faf]/)? '' :<p className="mb-0">{p.children}</p>}
                </>
              ),
              code : CodeBox
            }
          }
        />
      </section>
    </div>
  )
}

export default DemoCard
