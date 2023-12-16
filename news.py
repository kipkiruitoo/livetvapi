from newscatcher import Newscatcher
from newscatcher import urls
import json

urls = urls(topic = None, language = None, country = "GB")

with open("urls.json", "w") as file:
    json.dump(urls, file)

nc = Newscatcher(website = 'bbc.co.uk', topic="sport")

results = nc.get_news()
articles = results['articles']

with open("public/news.json", "w") as file:
    json.dump(articles, file)