<?php
/* 
 *Yemen Sounds 2026 
 */

header("Content-type: text/css");
require("global.php");
print get_template("css");
print '

/* Global responsive refresh */
:root{
  --bg: #f6f8fb;
  --surface: #ffffff;
  --surface-alt: #f0f4f8;
  --text: #17212b;
  --muted: #5f6b7a;
  --border: #d9e2ec;
  --accent: #1463ff;
  --accent-soft: #e8f0ff;
  --shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
  --radius: 10px;
}

*{
  box-sizing: border-box;
}

html{
  -webkit-text-size-adjust: 100%;
}

body{
  margin: 0;
  background: var(--bg);
  color: var(--text);
  font-family: Tahoma, Arial, sans-serif;
  line-height: 1.65;
}

table{
  max-width: 100%;
}

img{
  max-width: 100%;
  height: auto;
}

a{
  color: var(--accent);
  text-decoration: none;
}

a:hover{
  text-decoration: underline;
}

input,
select,
textarea,
button{
  font: inherit;
}

input[type=text],
input[type=password],
input[type=file],
select,
textarea{
  max-width: 100%;
  padding: 9px 10px;
  border: 1px solid var(--border);
  border-radius: 8px;
  background: #fff;
  color: var(--text);
}

input[type=submit],
input[type=button],
button{
  padding: 9px 14px;
  border: 1px solid #0f56de;
  border-radius: 8px;
  background: var(--accent);
  color: #fff;
  cursor: pointer;
}

input[type=submit]:hover,
input[type=button]:hover,
button:hover{
  filter: brightness(0.97);
}

.grid,
table.grid{
  width: 100%;
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
  overflow: hidden;
}

.row_1{
  background: #ffffff;
}

.row_2{
  background: #f8fbff;
}

.title{
  color: var(--text);
  font-size: 1.1rem;
  font-weight: bold;
}

.small{
  color: var(--muted);
}

fieldset{
  border: 1px solid var(--border);
  background: var(--surface);
  border-radius: var(--radius);
}

hr.separate_line{
  border: 0;
  border-top: 1px solid var(--border);
}

iframe{
  max-width: 100%;
}

@media (max-width: 900px){
  body{
    font-size: 15px;
  }

  table[width=\"90%\"],
  table[width=\"80%\"],
  table[width=\"70%\"],
  table[width=\"60%\"],
  table[width=\"50%\"],
  table[width=\"99%\"],
  table[width=\"100%\"]{
    width: 100% !important;
  }

  td,
  th{
    word-break: break-word;
  }

  input[type=text],
  input[type=password],
  input[type=file],
  select,
  textarea{
    width: 100%;
  }
}

@media (max-width: 640px){
  body{
    font-size: 14px;
    line-height: 1.55;
  }

  table,
  tbody,
  tr,
  td{
    max-width: 100%;
  }

  table.grid{
    display: block;
    overflow-x: auto;
  }

  input[type=submit],
  input[type=button],
  button{
    width: 100%;
  }
}

/* Singer experience refresh */
.singer-page{
  padding: 8px 0 28px;
}

.singer-page-shell{
  width: min(1120px, calc(100% - 24px));
  margin: 0 auto;
}

.singer-page-path{
  margin-bottom: 10px;
}

.singer-page .path{
  display: block;
  padding: 10px 14px;
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 10px;
  box-shadow: var(--shadow);
  color: var(--muted);
}

.singer-hero-card,
.singer-content-card,
.singer-page-nav{
  margin-top: 16px;
}

.singer-hero-card > *,
.singer-content-card > *,
.singer-page-nav > *{
  width: 100%;
}

.singer-content-card .grid,
.singer-bio-card .grid{
  border-radius: 14px;
}

.singer-bio-card{
  line-height: 1.8;
}

.singer-page .title{
  font-size: 1.2rem;
}

@media (max-width: 900px){
  .singer-page-shell{
    width: min(100%, calc(100% - 16px));
  }

  .singer-page .path{
    padding: 9px 12px;
  }
}

/* Songs page refresh */
.songs-page{
  padding: 8px 0 28px;
}

.songs-page-shell{
  width: min(1120px, calc(100% - 24px));
  margin: 0 auto;
}

.songs-page-path{
  margin-bottom: 10px;
}

.songs-page .path{
  display: block;
  padding: 10px 14px;
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 10px;
  box-shadow: var(--shadow);
  color: var(--muted);
}

.songs-hero-card,
.songs-content-card,
.songs-page-nav{
  margin-top: 16px;
}

.songs-hero-card > *,
.songs-content-card > *,
.songs-page-nav > *{
  width: 100%;
}

.songs-albums-card .grid,
.songs-list-card .grid{
  border-radius: 14px;
}

.songs-albums-card td,
.songs-list-card td{
  vertical-align: top;
}

.songs-list-card .title,
.songs-albums-card .title{
  font-size: 1.15rem;
}

@media (max-width: 900px){
  .songs-page-shell{
    width: min(100%, calc(100% - 16px));
  }

  .songs-page .path{
    padding: 9px 12px;
  }
}

/* Videos page refresh */
.videos-page{
  padding: 8px 0 28px;
}

.videos-page-shell{
  width: min(1120px, calc(100% - 24px));
  margin: 0 auto;
}

.videos-page-path{
  margin-bottom: 10px;
}

.videos-page .path{
  display: block;
  padding: 10px 14px;
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 10px;
  box-shadow: var(--shadow);
  color: var(--muted);
}

.videos-hero-card,
.videos-content-card,
.videos-page-nav{
  margin-top: 16px;
}

.videos-hero-card > *,
.videos-content-card > *,
.videos-page-nav > *{
  width: 100%;
}

.videos-cats-card .grid,
.videos-list-card .grid{
  border-radius: 14px;
}

.videos-cats-card td,
.videos-list-card td{
  vertical-align: top;
}

.videos-list-card .title,
.videos-cats-card .title{
  font-size: 1.15rem;
}

@media (max-width: 900px){
  .videos-page-shell{
    width: min(100%, calc(100% - 16px));
  }

  .videos-page .path{
    padding: 9px 12px;
  }
}

/* Video watch refresh */
.video-watch-page{
  padding: 8px 0 28px;
}

.video-watch-shell{
  width: min(1120px, calc(100% - 24px));
  margin: 0 auto;
}

.video-watch-path{
  margin-bottom: 10px;
}

.video-watch-page .path{
  display: block;
  padding: 10px 14px;
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 10px;
  box-shadow: var(--shadow);
  color: var(--muted);
}

.video-watch-card,
.video-watch-nav{
  margin-top: 16px;
}

.video-watch-card > *,
.video-watch-nav > *{
  width: 100%;
}

.video-watch-card .grid{
  border-radius: 14px;
}

@media (max-width: 900px){
  .video-watch-shell{
    width: min(100%, calc(100% - 16px));
  }

  .video-watch-page .path{
    padding: 9px 12px;
  }
}

/* Albums page refresh */
.albums-page{
  padding: 8px 0 28px;
}

.albums-page-shell{
  width: min(1120px, calc(100% - 24px));
  margin: 0 auto;
}

.albums-content-card{
  margin-top: 16px;
}

.albums-content-card > *{
  width: 100%;
}

.albums-filter-card .grid,
.albums-list-card .grid{
  border-radius: 14px;
}

.albums-filter-card .big{
  display: inline-block;
  margin: 4px 6px;
}

@media (max-width: 900px){
  .albums-page-shell{
    width: min(100%, calc(100% - 16px));
  }
}

/* News page refresh */
.news-page{
  padding: 8px 0 28px;
}

.news-page-shell{
  width: min(1120px, calc(100% - 24px));
  margin: 0 auto;
}

.news-page-path{
  margin-bottom: 10px;
}

.news-page .path{
  display: block;
  padding: 10px 14px;
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 10px;
  box-shadow: var(--shadow);
  color: var(--muted);
}

.news-content-card{
  margin-top: 16px;
}

.news-content-card > *{
  width: 100%;
}

.news-cats-card .grid,
.news-listing-card .grid,
.news-article-card .grid,
.news-comments-card .grid{
  border-radius: 14px;
}

@media (max-width: 900px){
  .news-page-shell{
    width: min(100%, calc(100% - 16px));
  }

  .news-page .path{
    padding: 9px 12px;
  }
}

/* Browse page refresh */
.browse-page{
  padding: 8px 0 28px;
}

.browse-page-shell{
  width: min(1120px, calc(100% - 24px));
  margin: 0 auto;
}

.browse-content-card{
  margin-top: 16px;
}

.browse-content-card > *{
  width: 100%;
}

.browse-cats-card .grid,
.browse-singers-card .grid{
  border-radius: 14px;
}

@media (max-width: 900px){
  .browse-page-shell{
    width: min(100%, calc(100% - 16px));
  }
}

/* Search page refresh */
.search-page{
  padding: 8px 0 28px;
}

.search-page-shell{
  width: min(1120px, calc(100% - 24px));
  margin: 0 auto;
}

.search-content-card{
  margin-top: 16px;
}

.search-content-card > *{
  width: 100%;
}

.search-results-card .grid{
  border-radius: 14px;
}

@media (max-width: 900px){
  .search-page-shell{
    width: min(100%, calc(100% - 16px));
  }
}

/* Login form polish */
.login-form-card{
  max-width: 360px;
  margin: 0 auto;
}

.login-form-table{
  width: 100% !important;
}

.login-form-table td{
  padding: 6px 4px;
}
';
?>
