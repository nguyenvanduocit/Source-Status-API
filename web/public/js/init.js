(
	function ( $ ) {
		var InforRequest = function(selector){
			this.$el = $(selector);
			this.request =function(){
				var self = this;
				var ip = this.$el.data('ip');
				var port = this.$el.data('port');
				$.ajax({
					url : ajaxUrl,
					type : "post",
					data : {
						serverIp:ip,
						port:port
					},
					success : function (result){
						if(result.success){
							self.fillResult(result.data);
						}
						else{
							self.$el.find('.loadingPlaceHolder' ).text('Error : ' + result.message);
						}
					}
				});
			};
			this.fillResult  =function(data)
			{
				var listContainer = this.$el.find('.infoListContainer');
				listContainer.find('.loadingPlaceHolder').remove();
				var info = data.info;

				var mapPlaceHolder = this.$el.find('.mapPlaceHolder');
				mapPlaceHolder.text(info.Map);

				var statPlaceHolder = this.$el.find('.statPlaceHolder');
				var realPlayer = info.Players - info.Bots;
				statPlaceHolder.text(realPlayer +'/' + info.MaxPlayers);

				if(realPlayer > 0){
					var players = data.players;
					players.sort(function(a, b) {
						return a.Frags < b.Frags;
					});
					for(var index = 0; index < players.length; index++){
						listContainer.append(this.generateItem(players[index ].Name,players[index ].Frags + ' điểm'));
					}
				}
				else{
					listContainer.append('<li class="collection-item">Hiện không có người chơi nào</li>');
				}

			};
			this.generateItem = function(name,text){
				return '<li class="collection-item row"><strong class="col s12 m8">'+name+'</strong> <span class="col s12 m4">' + text + '</span></li>';
			}
		};

		$( function () {

			var window_width = $( window ).width();

			// Floating-Fixed table of contents
			if ( $( 'nav' ).length ) {
				$( '.toc-wrapper' ).pushpin( {top: $( 'nav' ).height()} );
			}
			else if ( $( '#index-banner' ).length ) {
				$( '.toc-wrapper' ).pushpin( {top: $( '#index-banner' ).height()} );
			}
			else {
				$( '.toc-wrapper' ).pushpin( {top: 0} );
			}


			// Detect touch screen and enable scrollbar if necessary
			function is_touch_device() {
				try {
					document.createEvent( "TouchEvent" );
					return true;
				} catch ( e ) {
					return false;
				}
			}

			if ( is_touch_device() ) {
				$( '#nav-mobile' ).css( {overflow: 'auto'} );
			}
			/**
			 * Request for server info
			 */
			function requestServerStat() {
				var infoContainers = $('.serverInfoContainer');
				for(var index = 0; index< infoContainers.length; index++){
					var request = new InforRequest(infoContainers[index]);
					request.request();
				}
			}
			requestServerStat()
		} ); // end of document ready
	}
)( jQuery ); // end of jQuery name space
