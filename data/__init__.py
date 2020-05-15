import markdown
import os
import shelve
import pickle
import datetime
from Hash import Hash

# Import the framework
from flask import Flask, g
from flask_restful import Resource, Api, reqparse

# Create an instance of Flask
app = Flask(__name__)

#Creat the API
api = Api(app)

hashID = pickle.load( open( "data/hash_map.p", "rb" ) )

def saveData():
    pickle.dump(hashID, open("data/hash_map.p", "wb") )

def get_db():
    db = getattr(g, '_database', None)
    if db is None:
        db = g._database = shelve.open("photos.db")
    return db 

@app.teardown_appcontext
def teardown_db(exception):
    db = getattr(g, '_database', None)
    if db is not None:
        db.close()

@app.route("/")
def index():
    '''Present some documentation'''

    # Open the README file
    with open(os.path.dirname(app.root_path) + '/README.md', 'r') as markdown_file:

        # Read the conetnet of the file
        content = markdown_file.read()

        # Convert to HTML
        return markdown.markdown(content)

class PhotoList(Resource):
    def get(self):
        shelf = get_db()
        keys = list(shelf.keys())
        
        photos = []

        for key in keys:
            photos.append(shelf[key])
        
        return {'message': 'Success', 'data' : photos}, 200
    
    def post(self):
        parser = reqparse.RequestParser()
        shelf = get_db()
        
        parser.add_argument('file_name', required=True)
        parser.add_argument('size', required=True)
        parser.add_argument('descriptor', required=True)

        #Parse the arguments into an object
        args = parser.parse_args()
        
        ID = str(hashID.generate(args['file_name']))
        args['identifier'] = ID
        args['date_modified'] = str(datetime.datetime.now())

        shelf = get_db()
        shelf[args['identifier']] = args
        
        saveData()
        
        return {'message' : 'Photo registered', 'data' : args}, 201

class Photo(Resource):
    def get(self, identifier):
        shelf = get_db()

        # If the key does not exist in the data store, return a 404 error
        if not (identifier in shelf):
            return {'message': 'Photo not found', 'data':{}}, 404

    def delete(self, identifier):
        hashID.array [int(identifier)] = -1
        saveData()
        shelf = get_db()

        # If the key doe not exist in the data store, return a 404 error
        if not (identifier in shelf):
            return {'message':'Photo not found', 'data':{}}, 404

        del shelf[identifier]
        
        return '', 204

api.add_resource(PhotoList, '/photos')
api.add_resource(Photo, '/photos/<string:identifier>')
