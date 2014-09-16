      function startIntro(){
        var intro = introJs();
          intro.setOptions({
            steps: [
              {
                element: document.querySelector('#step1'),
                intro: 'if not a member of <span style="color:#c70000;"><b>NetworkWe.com</b></span> you can sign up from here...',
				 position: 'left'
              },
              {
                element: document.querySelectorAll('#step2')[0],
                intro: 'If you already registered with <span style="color:#c70000;"><b> NetworkWe.com </b></span>you can login from here...',
                position: 'top'
              },
              { 
                element: '#step3',
                intro: 'You can search millions of professional and connect with them, Also you can search jobs in one place',
                position: 'left'
              },
            ]
          });
          intro.start();
      }