import { useEffect, useRef, useState } from "react";
import {
    Alert,
    Button,
    Col,
    Container,
    Form,
    Image,
    InputGroup,
    Modal,
    Row,
} from "react-bootstrap";
import { Plus, TrashFill } from "react-bootstrap-icons";
import { AsyncTypeahead } from "react-bootstrap-typeahead";
import { useNavigate, useParams } from "react-router-dom";
import CardGrid from "../components/CardGrid";
import Loading from "../components/Loading";
import BootstrapModal from "../components/Modal";
import { useCardSearch } from "../hooks/useCardSearch";
import api from "../services/api";

const EditDeck = () => {
    const [id, setId] = useState(null);
    const [name, setName] = useState("");
    const [commanderName, setCommanderName] = useState([""]);
    const [commanderImage, setCommanderImage] = useState("");
    const commanderNameInput = useRef();

    const [searchCard, setSearchCard] = useState("");
    const searchcardInput = useRef();

    const [deckCards, setDeckCards] = useState([]);

    const navigate = useNavigate();
    const { options, search, loading: cardLoading } = useCardSearch();
    const {
        options: optionsSearch,
        search: searchSearch,
        loading: searchLoading,
    } = useCardSearch();
    const [loading, setLoading] = useState(false);
    const [errors, setErrors] = useState([]);
    const { deckId } = useParams();

    const [selectedCard, setSelectedCard] = useState(false);

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

            clearSearch();

            setLoading(false);
        } catch (error) {
            console.log(error.response);
        }
    }

    const clearSearch = () => {
        // clear search card input
        setSearchCard([]);
        searchcardInput.current.state.text = "";
    };

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

    const [addCardError, setAddCardError] = useState(false);

    const addCard = async (e) => {
        setLoading(true);
        setAddCardError(false);
        let card_name =
            searchcardInput.current.state.selected.length === 0
                ? searchcardInput.current.state.text
                : searchcardInput.current.state.selected[0];
        const formData = { card_name };
        try {
            const response = await api.put(`/decks/${id}/add-card`, formData);
            console.log(response);
            addOrUpdateCardInList(response.data.data);
        } catch (error) {
            console.log(error.response);
            setAddCardError(error.response.data.message);
        }
        clearSearch();
        setLoading(false);
    };

    const addOrUpdateCardInList = (newCard) => {
        // Check if the item already exists by finding its index
        const existingItemIndex = deckCards[newCard.type].items.findIndex(
            (card) => card.id === newCard.id,
        );

        if (existingItemIndex !== -1) {
            // if the item exists
            deckCards[newCard.type].items[existingItemIndex] = newCard; // Update the item with new data
        } else {
            // If the item does not exist, add it to the end of a new array
            deckCards[newCard.type].items.push(newCard);
        }

        deckCards[newCard.type].count += 1;
    };

    return (
        <>
            <Container className="mt-4" fluid>
                <h1>Edit Deck</h1>
                <hr />
                <Row>
                    {/* Commander name/card form */}
                    <Col className="col-md-3 col-12 mb-4">
                        <Image
                            src={commanderImage}
                            rounded
                            width={250}
                            fluid
                            className="d-block mx-auto"
                            onClick={() => setSelectedCard()}
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
                    <Col className="col-md-9 col-12">
                        {/* search */}
                        {addCardError !== false && (
                            <BootstrapModal
                                title="Error"
                                id="errorModal"
                                showModal={typeof addCardError === "string"}
                                setShowModal={setAddCardError}
                                error={true}
                            >
                                <h6>{addCardError}</h6>
                            </BootstrapModal>
                        )}
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
                            <Button
                                id="button-addon2"
                                onClick={() => addCard()}
                            >
                                <span>Add</span> <Plus className="mb-1" />
                            </Button>
                        </InputGroup>

                        {/* cards list */}
                        {deckCards && (
                            <CardGrid
                                cards={deckCards}
                                onClick={setSelectedCard}
                            />
                        )}

                        {/* selected card modal */}
                        {selectedCard && (
                            <BootstrapModal
                                title={selectedCard.name}
                                id="selectedCardModal"
                                showModal={selectedCard !== false}
                                setShowModal={setSelectedCard}
                                size="lg"
                            >
                                <Image
                                    src={selectedCard.image_url}
                                    rounded
                                    fluid
                                    alt={selectedCard.name}
                                />
                                <Modal.Footer>
                                    <Button fluid className="w-100 rounded m-0">
                                       <TrashFill /> Remove
                                    </Button>
                                </Modal.Footer>
                            </BootstrapModal>
                        )}
                    </Col>
                </Row>
            </Container>

            {loading && <Loading />}
        </>
    );
};

export default EditDeck;
