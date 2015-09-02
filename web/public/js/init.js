(
	function ( $, Backbone, Marionette, _, myApp ) {

		var PlayerModel = Backbone.Model.extend({

		});
		var PlayerCollection = Backbone.Collection.extend({
			model:PlayerModel
		});
		var PlayerItemView = Marionette.ItemView.extend({
			template: "#PlayerItemTemplate",
			tagName:'li',
			className:'collection-item row'
		});
		var PlayerListLoadingView =  PlayerItemView.extend({
			template: "#PlayerListLoadingTemplate"
		});

		var PlayerCollectionView = Marionette.CollectionView.extend({
			childView: PlayerItemView,
			tagName:'ul',
			emptyView : PlayerListLoadingView,
		});


		var InfoRequest = function(selector){

			this.$el = $(selector);
			this.collection = new PlayerCollection();
			this.ip = this.$el.data('ip');
			this.port = this.$el.data('port');
			this.appid = this.$el.data('appid');
			this.listContainer = this.$el.find('.infoListContainer');
			this.mapNameEl = this.$el.find('.mapPlaceHolder');
			this.playerCountEl = this.$el.find('.statPlaceHolder');
			this.playerListView = new PlayerCollectionView({
				el:this.listContainer,
				collection:this.collection
			});
			this.noticeView = this.$el.find('.notice');
			this.playerListView.render();
			this.collection.comparator = function(model) {
				return -model.get('Frags');
			};
			this.request =function(){
				var self = this;
				$.ajax({
					url : ajaxUrl,
					type : "post",
					data : {
						serverIp:this.ip,
						port:this.port,
						appid:this.appid,
					},
					success : function (result){
						if(result.success){
							var data = result.data;
							if(data.info != false){
								self.noticeView.addClass('hide');
								self.listContainer.removeClass('hide');
								self.mapNameEl.text(data.info.Map);
								var realPlayer = data.info.Players - data.info.Bots;
								if(realPlayer === 0){
									self.playerListView.emptyView = PlayerListEmptyView;
								}
								self.playerCountEl.text( realPlayer + '/' + data.info.MaxPlayers);
								self.collection.reset(data.players);
								self.collection.sort();
							}
							else{
								/**
								 * Server not response
								 */
								self.noticeView.removeClass('hide');
								self.listContainer.addClass('hide');
								self.noticeView.text('Server ?ang g?p s? c?.');
							}
						}
						else{
							self.$el.find('.loadingPlaceHolder' ).text('Error : ' + result.message);
						}
					}
				});
			};
			this.startInterval = function(){
				var self=this;
				setInterval(function(){self.request()}, 10000);
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
					var request = new InfoRequest(infoContainers[index]);
					request.request();
					request.startInterval();
				}
			}
			requestServerStat()
		} ); // end of document ready
	}
)( jQuery, Backbone,Marionette, _, window.myApp ); // end of jQuery name space
