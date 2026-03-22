import React, { useEffect, useRef, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import {
    Form,
    Button,
    Container,
    Alert,
    Row,
    Col,
    Image,
    InputGroup,
    FormControl,
} from "react-bootstrap";
import { AsyncTypeahead } from "react-bootstrap-typeahead";
import { useCardSearch } from "../hooks/useCardSearch";
import api from "../services/api";
import Loading from "../components/Loading";
import { Plus, PlusSquare, PlusSquareFill } from "react-bootstrap-icons";
import CardGrid from "../components/CardGrid";

const EditDeck = () => {
    const [id, setId] = useState(null);
    const [name, setName] = useState("");
    const [commanderName, setCommanderName] = useState([""]);
    const [commanderImage, setCommanderImage] = useState("");
    const commanderNameInput = useRef();
    
    const [searchCard, setSearchCard] = useState("")
    const [searchCardImage, setSearchCardImage] = useState("");
    const searchcardInput = useRef();

    const [deckCards, setDeckCards] = useState([]);

    const navigate = useNavigate();
    const { options, search, loading: cardLoading } = useCardSearch();
    const { options: optionsSearch, search: searchSearch, loading: searchLoading } = useCardSearch();
    const [loading, setLoading] = useState(false);
    const [errors, setErrors] = useState([]);
    const { deckId } = useParams();

    useEffect(() => {
        loadDeck();
    }, []);

    async function loadDeck() {
        try {
            setLoading(true);
            const response = await api.get(`/decks/${deckId}`);

            console.log(response);

            setId(response.data.data.id);
            setName(response.data.data.name);
            setCommanderName([response.data.data.commander_name]);

            // get commander image
            setCommanderImage(response.data.data.image_url);

            console.log(response.data.data.cards);
            setDeckCards(response.data.data.cards);

            // clear search card input
            setSearchCard([]);
            searchcardInput.current.state.text = "";

            setLoading(false);
        } catch (error) {
            console.log(error.response);
        }
    }

    const editDeck = async (e) => {
        e.preventDefault();
        setLoading(true);
        let commander_name =
            commanderNameInput.current.state.selected.length === 0
                ? commanderNameInput.current.state.text
                : commanderNameInput.current.state.selected[0];
        setErrors([]);
        const formData = { id, name, commander_name };
        console.log(formData);
        try {
            await api.put(`/decks/${id}`, formData);
            navigate("/");
        } catch (error) {
            if (error.response && error.response.status === 422) {
                setErrors(error.response.data.errors);
            } else {
                console.log(error.response.data);
                setErrors({ commander_name: [error.response.data.message] });
            }
        }
        setLoading(false);
    };

    const addCard = async (e) => {
        setLoading(true);
        // setErrors([]);
        let card_name =
            searchcardInput.current.state.selected.length === 0
                ? searchcardInput.current.state.text
                : searchcardInput.current.state.selected[0];
        const formData = { card_name };
        console.log(formData);
        try {
            await api.put(`/decks/${id}/add-card`, formData);
            loadDeck();
        } catch (error) {
            // if (error.response && error.response.status === 422) {
            //     setErrors(error.response.data.errors);
            // } else {
            //     console.log(error.response.data);
            //     setErrors({ commander_name: [error.response.data.message] });
            // }
        }
        setLoading(false);
    }

    return (
        <>
            <Container className="mt-4" fluid>
                <h1>Edit Deck</h1>
                <hr />
                <Row>
                    {/* Commander name/card form */}
                    <Col className="col-md-4 col-12 mb-4">
                        <Image
                            src={commanderImage}
                            rounded
                            width={250}
                            fluid
                            className="d-block mx-auto"
                        />
                        <Form onSubmit={editDeck}>
                            <input type="hidden" name="id" value={id} />
                            <Form.Group className="mb-3" controlId="name">
                                <Form.Label>Name</Form.Label>
                                <Form.Control
                                    type="text"
                                    placeholder="Enter the deck name"
                                    value={name}
                                    onChange={(e) => setName(e.target.value)}
                                />
                            </Form.Group>
                            {errors.name && (
                                <Alert
                                    key="name"
                                    variant="danger"
                                    className="mt-3"
                                >
                                    {errors.name[0]}
                                </Alert>
                            )}

                            <Form.Group className="mb-3">
                                <Form.Label>Commander</Form.Label>
                                <AsyncTypeahead
                                    id="commander-autocomplete"
                                    isLoading={cardLoading}
                                    ref={commanderNameInput}
                                    onSearch={search}
                                    options={options}
                                    selected={commanderName}
                                    onChange={setCommanderName}
                                    placeholder="Type your commander name..."
                                    clearButton
                                />
                            </Form.Group>
                            {errors.commander_name && (
                                <Alert
                                    key="danger"
                                    variant="danger"
                                    className="mt-3"
                                >
                                    {errors.commander_name[0]}
                                </Alert>
                            )}
                            <Container>
                                <Row className="align-items-center">
                                    <Col className="text-center">
                                        <Button
                                            variant="secondary"
                                            className="me-2"
                                            onClick={() => navigate("/")}
                                        >
                                            Back
                                        </Button>
                                        <Button type="submit" variant="primary">
                                            Save
                                        </Button>
                                    </Col>
                                </Row>
                            </Container>
                        </Form>
                    </Col>

                    {/* Card search and card list */}
                    <Col className="col-md-8 col-12">
                        {/* search */}
                        <InputGroup className="mb-3">
                            <AsyncTypeahead
                                id="search-autocomplete"
                                isLoading={searchLoading}
                                ref={searchcardInput}
                                onSearch={searchSearch}
                                options={optionsSearch}
                                selected={searchCard}
                                onChange={setSearchCard}
                                placeholder="Find and add cards to deck..."
                                clearButton
                                className="form-control border-0 p-0"
                            />
                            <Button id="button-addon2" onClick={() => addCard()}>
                                <span>Add</span> <Plus className="mb-1" />
                            </Button>
                        </InputGroup>

                        {/* cards list */}
                        {deckCards && <CardGrid cards={deckCards}/>}
                    </Col>
                </Row>
            </Container>

            {loading && <Loading />}
        </>
    );
};

export default EditDeck;
